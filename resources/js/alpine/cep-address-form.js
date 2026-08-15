export default function cepAddressForm(cepUrlTemplate, initial = {}) {
    return {
        showAddress: false,

        cepLoading: false,
        cepError: '',

        addr: {
            zip_code: initial.zip_code ?? '',
            street: initial.street ?? '',
            number: initial.number ?? '',
            neighborhood: initial.neighborhood ?? '',
            city: initial.city ?? '',
            state: initial.state ?? '',
            complement: initial.complement ?? '',
        },

        onZipInput() {
            this.addr.zip_code = this.addr.zip_code.replace(/\D/g, '');

            if (this.addr.zip_code.length === 8) {
                this.buscarCep();
            }
        },

        buscarCep() {
            if (this.addr.zip_code.length !== 8) return;

            this.cepLoading = true;
            this.cepError = '';

            fetch(cepUrlTemplate.replace('__CEP__', this.addr.zip_code))
                .then((r) => r.json())
                .then((d) => {
                    if (d.error) {
                        this.cepError = d.error;
                        return;
                    }

                    this.addr.street = d.logradouro || '';
                    this.addr.neighborhood = d.bairro || '';
                    this.addr.city = d.localidade || '';
                    this.addr.state = d.uf || '';
                    this.addr.complement = d.complemento || '';
                })
                .catch(() => (this.cepError = 'Erro ao buscar CEP.'))
                .finally(() => (this.cepLoading = false));
        },
    };
}
