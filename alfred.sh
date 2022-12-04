#!/bin/bash

## DEFAULT UTILITYS
declare workdir=$(eval echo ${WORKDIR:-$PWD})

declare docker_opts="--rm -v ${workdir}:/app"
# SELECT INTERACTIVE
[ -z $PS1 ] \
    || docker_opts="$docker_opts -it"

declare docker_run="docker run $docker_opts"
declare composer="$docker_run -u $(id -u):$(id -g) composer"
declare artisan="$composer php artisan"
declare npm="$docker_run -w /app node npm"
declare exe="docker compose exec "
# ENV DEFAULT
export APP_PORT=${APP_PORT:-8000}
export WWWUSER=${WWWUSER:-$(id -u)}
export WWWGROUP=${WWWGROUP:-$(id -g)}

## SAIL ROLLBACK
function sail {
    if [[ $1 == 'sail' ]]; then
        shift
        [[ -f docker-compose.yml ]] \
            || cp ./deployment/docker/sail-compose.yml ./docker-compose.yml \
            && echo "Copiando docker-compose.yml..."
        ./vendor/bin/sail ${1:-up -d} \
            && echo "INICIO CON SAIL" \
            || return 1
        return 0
    fi
}


## COPY AND LOAD ENV
function env_setup {
    echo "Iniciando env"
    if [ ! -e .env ]; then
        echo "no existe .env ... copiando default"
        cp ./.env.example ./.env
        set_artisan
    fi
    while read env_var
    do
        export $env_var 1> /dev/null
    done < "$workdir/.env"
    echo ".env sourced"
    return 0
}

## SSL BUILD
function ssl {
    cert_dir="$workdir/deployment/docker/proxy/certs"
    [ ! -d $cert_dir ] && mkdir $cert_dir
    if [[ -e $cert_dir/ca-key.pem && -e $cert_dir/ca.pem ]]; then
        $workdir/deployment/scripts/gen-self-ssl.sh --dir=$cert_dir ${@}
    else
        echo "No se puede generar el certificado sin un ca.pem"
        return 1
    fi
}


## BUILD COMPOSER
function compose {
    $composer update \
        && $composer install \
        || return 1
}

## BUILD WEBPACK
function build_webpack {
    $npm install \
        && $npm run build \
        && $npm audit fix --force \
        || return 1
}

## GEN KEY
function set_artisan {
    $artisan key:generate \
        || return 1
}

## HELP
function helpAlfred {
    echo "
-d --deploy     docker compose wraper
-b --build     build process
--env       show env
    "
# --ssl       Generate SSL Script

    return 1
}

## -------------------------------------------- EXECUTION POINTS // COMANDS
## BUILD
function build {
    compose \
        && build_webpack \
        || return 1
}

## DEPLOY
function deploy {
    docker-compose ${@:-up -d} \
        || return 1
}
## SET DEV ENVIROMENT
function dev {
    env_setup
    doc_dev="docker compose"
    session="laravite"
    # COMANDS
    if [[ ${1} == 'down' ]]; then
        echo "Apagando db"
        $doc_dev "down" && \
            tmux kill-session -t $session
        exit 0
    fi
    # dependecias
    if [ ! -f "vendor/autoload.php" ] ; then
        compose || exit 1
    fi
    if [ ! -e "node_modules" ] ; then
        $npm i || exit 1
    fi
    if [ ! -x $(which tmux) ] ; then
        echo "Instalar tmux para usar modo dev"
        exit 1
    fi
    #### FIX WORDIR DB SCRIPTS
    export WORKDIR=$workdir

    ## TMUX
    # Crea la session
    tmux new-session -d -s $session
    window=0
    tmux rename-window -t $session:$window 'db'
    tmux send-keys -t $session:$window "$doc_dev up" C-m
    window=1
    tmux new-window -t $session:$window -n 'serve'
    tmux send-keys -t $session:$window 'php artisan serve' C-m
    window=2
    tmux new-window -t $session:$window -n 'vite'
    tmux send-keys -t $session:$window 'npm run dev' C-m
    # Se atachea a la session
    if [[ ${1} == '-a' ]]; then
        tmux attach-session -t $session
    fi
}


## ------------------------------------------------------------------ MAIN
function main {
    # Iniciamos el ambiente
    echo "Lugar de trabajo: $workdir"
    env_setup
    if [[ ! -z $env_check ]] ; then
        env \
            || return 1
    fi
    # if [[ ! -z $ssl_init ]] ; then
    #     echo -e "Creando SSL\n\n"
    #     ssl ${@} \
    #         && return 0 \ || return 1
    # fi
    if [[ ! -z $builder ]] ; then
        build \
            || return 1
    fi
    if [[ ! -z $deployer ]] ; then
        deploy ${@} \
            || return 1
    fi
}

## OPTIONS
while getopts 'bdh-:' OPT; do
	case "${OPT}" in
		-)
			case "${OPTARG}" in
				env) declare env_check=1 ;;
				ssl) declare ssl_init=1 ; shift;;
				*) echo "${OPTARG}" ;;
			esac
			;;
		b) declare builder=1 ;;
		d) declare deployer=1 ; shift ;;
        h) helpAlfred ;;
        :) helpAlfred ;;
		?) helpAlfred ;;
	esac
done

if [ ${1} == 'dev' ]; then
    shift 1
    dev ${@} \
        && exit 0
else
    main ${@} \
        && exit 0 \
        || exit 1
fi


