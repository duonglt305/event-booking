import Tickets from './tickets'
import Channels from './channels'
import Rooms from './rooms'
import Sessions from './sessions'
import Partners from "./partners";
import Article from "./articles";
import Axios from 'axios';
import Helpers from "./helpers";

class Detail {
    constructor() {
        this.$updateEventStatus = $('#update-event-status');
        this.init();
    }

    init() {
        new Tickets();
        new Channels();
        new Rooms();
        new Sessions();
        new Partners();
        new Article();

        this.$updateEventStatus.click(event => {
            event.preventDefault();
            let url = this.$updateEventStatus.attr('href');
            Axios.post(url)
                .then(
                    res => {
                        if (res.data.message) {
                            Helpers.showToast(res.data.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    err => {
                        Helpers.showToast(err.response.data.message, 'error');
                    }
                )
        })
    }
}

$(() => {
    new Detail();
});
