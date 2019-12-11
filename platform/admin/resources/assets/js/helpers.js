export default class Helpers {
    static showInputErrors(errors, prefix = '') {
        Object.keys(errors).map(key => {
            let message = errors[key][0];
            let select = prefix !== '' ? `#${prefix}_${key}` : `#${key}`;
            let formControl = $(select);
            Helpers.hideInputErrors(formControl);
            formControl.addClass('is-invalid')
                .parent()
                .append(`<div class="invalid-feedback">${message}</div>`);
            formControl.unbind('focus');
            formControl.focus(() => {
                formControl.removeClass('is-invalid')
                    .parent()
                    .find('.invalid-feedback')
                    .remove();
            });
        })
    }

    static hideInputErrors(formControl, reset = false) {
        formControl.unbind('focus');
        formControl.removeClass('is-invalid')
            .parent()
            .find('.invalid-feedback')
            .remove();
        if (reset) formControl.val(null);
    }

    static showToast(message, type = 'success') {
        $.toast({
            heading: 'Notification',
            text: message,
            showHideTransition: 'slide',
            icon: type,
            loaderBg: '#f2a654',
            position: 'top-right'
        })
    }

    static toSlug(str) {
        let slug = str.toLowerCase();

        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        return slug;
    }
}
