import Helpers from "./helpers";
import Axios from "axios";

export default class SessionTypes {
    constructor() {
        this.$modalCreate = $('#session_type_modal_create');
        this.$formCreate = $('#session_type_form_create');
        this.init();
    }

    init() {
        this.initCreate();
    }

    initCreate() {
        this.$modalCreate.on('show.bs.modal', () => {
            this.$formCreate.find('.form-control').each((index, input) => {
                Helpers.hideInputErrors($(input), true);
            });
        });
        this.$formCreate.submit(e => {
            e.preventDefault();
            let action = $(e.target).attr('action');
            Axios.post(action, new FormData(e.target)).then(res => {
                Helpers.showToast(res.data.message);
                this.$modalCreate.modal('hide');
            }).catch(err => {
                if (err.response.status === 422)
                    Helpers.showInputErrors(err.response.data.errors, 'session_type');
                else {
                    Helpers.showToast(err.response.data.message, 'error');
                }
            })
        })
    }
}
