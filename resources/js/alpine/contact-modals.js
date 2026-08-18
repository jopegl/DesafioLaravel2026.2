export default function contactModals() {
    return {
        showReply: false,
        selected: null,

        openReply(item) {
            this.selected = item;
            this.showReply = true;
        },
    };
}