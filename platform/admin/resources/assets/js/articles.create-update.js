import Helpers from "./helpers";
import Axios from 'axios';

class Articles {
    constructor() {
        this.$formArticle = $('#form_article');
        this.$title = $('#title');
        this.$description = $('#description');
        this.$body = $('#body');
        this.$thumbnail = $('#thumbnail');
        this.init();
    }

    init() {
        this.$thumbnail.dropify();
        this.initCKEditor();
        this.initFrom();
    }

    initCKEditor() {
        CKEDITOR.replace('body', {
            height: 500
        });
    }

    initFrom() {
        this.$formArticle.submit(event => {
            event.preventDefault();
            this.$formArticle.find('button[type=submit]').prop('disabled', true);
            let url = $(event.target).attr('action');
            let fd = new FormData(event.target);
            fd.append('body', CKEDITOR.instances.body.getData());
            Axios.post(url, fd).then(
                ({data}) => {
                    if (data && data.message) {
                        Helpers.showToast(data.message);
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    }
                },
                err => {
                    this.$formArticle.find('button[type=submit]').prop('disabled', false);
                    if (err.response.data.errors) {
                        Helpers.showInputErrors(err.response.data.errors);
                    }
                    Helpers.showToast(err.response.data.message, 'error')
                }
            )
        });
    }
}

$(() => {
    new Articles();
});
