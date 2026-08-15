export default function addressModals() {
    return {
        showAddAddress: false,
        showEditAddress: false,
        showDeleteAccount: false,
        selectedAddress: null,

        openEditAddress(address) {
            this.selectedAddress = address;
            this.showEditAddress = true;
        },
    };
}
