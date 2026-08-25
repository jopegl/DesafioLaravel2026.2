
export default function crudModals() {
    return {
        showCreate: false,
        showView: false,
        showEdit: false,
        showDelete: false,
        selected: null,

        openView(item) {
            this.selected = item;
            this.showView = true;
        },

        openEdit(item) {
            this.selected = item;
            this.showEdit = true;
        },

        openDelete(item) {
            this.selected = item;
            this.showDelete = true;
        },
        formatDate(value) {
            if (!value) return '—';
            return new Date(value).toLocaleDateString('pt-BR', { timeZone: 'UTC' });
        },
    };
}
