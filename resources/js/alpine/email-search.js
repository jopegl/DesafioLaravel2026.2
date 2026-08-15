export default function emailSearch(searchUrl) {
    return {
        query: '',
        results: [],
        showResults: false,
        selectedUser: {
            id: null,
            name: '',
            email: '',
        },

        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }

            const response = await fetch(`${searchUrl}?q=${encodeURIComponent(this.query)}`);
            this.results = await response.json();
            this.showResults = true;
        },

        selectUser(user) {
            this.selectedUser = user;
            this.query = user.email;
            this.showResults = false;
        },
    };
}
