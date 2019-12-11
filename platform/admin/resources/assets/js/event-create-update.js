import Helpers from "./helpers";

class EventCreateUpdate {
    constructor() {
        this.$slug = $('input[name=slug]');
        this.$name = $('input[name=name]');
        this.init();
    }

    initCKEditor() {
        CKEDITOR.replace('description', {
            height: 200
        });
    }

    init() {
        this.initDropify();
        this.initCKEditor();
        this.$slug.focus(event => {
            if (this.$name.val() !== '' && this.$slug.val() === '') {
                this.$slug.val(Helpers.toSlug(this.$name.val()))
            }
        })
    }

    initDropify() {
        $('.dropify').dropify();
    }
}

$(() => {
    new EventCreateUpdate();
});
