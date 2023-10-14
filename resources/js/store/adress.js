import { defineStore } from 'pinia';

export const useAddressStore = defineStore({
    id: 'api',
    state: () => ({
        paisesData: null,
        estadosData: null,
        municipiosData: null,
        coloniasData: null
    }),
    actions: {
        async obtenerPaises() {
            try {
                const { data } = await axios.get(`/api/domicilio/paises`);
                this.paisesData = data;
            } catch (error) {
                console.error('Error en la solicitud:', error);
            }
        },
        async obtenerEstados(id) {
            try{
                const { data } = await axios.get(`/api/domicilio/estados/${id}`)
                this.estadosData = data
            }catch(error){
                console.error('Error en la solicitud:', error);
            }
        },
        async obtenerMunicipios(id) {
            try{
                const { data } = await axios.get(`/api/domicilio/municipios/${id}`)
                this.municipiosData = data
            }catch(error){
                console.error('Error en la solicitud:', error);
            }
        },
        async obtenerColonias(id) {
            try{
                const { data } = await axios.get(`/api/domicilio/colonias/${id}`)
                this.coloniasData = data
            }catch(error){
                console.error('Error en la solicitud:', error);
            }
        }
    },
});