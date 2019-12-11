import Axios from "axios";
import Helpers from "./helpers";

class EventReport {
    constructor() {
        this.$ticketsTable = $('#tickets-table');
        this.$roomOverview = $('#room-overview');
        this.$roomChart = $('#room-chart');
        this.$totalAttendees = $('#total-attendees');
        this.$attendeesCostPercent = $('#attendees-cost-percent');
        this.$totalSessions = $('#total-sessions');
        this.$totalArticles = $('#total-articles');
        this.$totalArticlesDetail = $('#total-articles-detail');
        this.$totalPartners = $('#total-partners');
        this.$sessionDetail = $('#session-detail');
        this.$channelChart = $('#channel-chart');
        this.$eventName = $('#event-name');
        this.$sessionRatingTable = $('#session-rating-table');
        this.$dropdownLastTenDay = $('#dropdown-last-ten-day');
        this.$dropdownToday = $('#dropdown-today');
        this.$attendeeRegistrationDetail = $('#attendee-registration-detail');
        this.selectTime = {
            from: this.$dropdownToday.data('from'),
            to: this.$dropdownToday.data('to')
        };
        this.reportRegistrationChart = null;
        this.colors = ['bg-warning', 'bg-primary', 'bg-danger', 'bg-success', 'bg-info'];
        this.init();
    }

    async init() {
        let {sessions} = await this.getDataSessions();
        let {event} = await this.getData();

        if (event.tickets) {
            this.ticketReport(event.tickets);
            this.attendeesReport(event.tickets)
        }
        if (event.rooms) this.roomReport(event.rooms);

        if (event.sessions) this.$totalSessions.text(event.sessions.length);

        this.sessionRatingsReport(event.sessions);

        if (event.articles && event.articles.length > 0) this.articleReport(event.articles);

        if (event.partners) this.partnersReport(event.partners);

        if (event.channels) this.channelReport(event.channels);

        this.sessionsReport(sessions);

        this.initRegistrationReport();


        this.$dropdownLastTenDay.click(event => {
            event.preventDefault();
            this.selectTime = {
                from: this.$dropdownLastTenDay.data('from'),
                to: this.$dropdownLastTenDay.data('to')
            };
            this.initRegistrationReport();
        });

        this.$dropdownToday.click(event => {
            event.preventDefault();
            this.selectTime = {
                from: this.$dropdownToday.data('from'),
                to: this.$dropdownToday.data('to')
            };
            this.initRegistrationReport();
        });
    }

    async initRegistrationReport(){
        let {registrations} = await this.getDataRegistration(this.selectTime.from, this.selectTime.to);
        this.attendeeRegistrationReport(registrations ? registrations : {});
    }

    getData() {
        return new Promise((resolve, reject) => {
                Axios.post(`/organizer/events/${this.$eventName.data('event')}/report`).then(
                    res => {
                        resolve(res.data);
                    },
                    err => {
                        reject(err)
                    }
                )
            }
        );
    }

    getDataSessions() {
        return new Promise((resolve, reject) => {
            Axios.post(this.$sessionDetail.data('url')).then(
                res => {
                    resolve(res.data);
                },
                err => {
                    reject(err)
                }
            )
        });
    }

    getDataRegistration(from, to) {
        return new Promise((resolve, reject) => {
            Axios.post(this.$attendeeRegistrationDetail.data('url'),
                {
                    from,
                    to
                }).then(
                res => {
                    resolve(res.data);
                },
                err => {
                    reject(err)
                }
            )
        });
    }

    ticketReport(tickets) {
        let html = tickets.reduce((current, next) => {
            let total = 0;
            let color = this.colors[Math.round(Math.random() * (this.colors.length - 1))];
            let booked = 0;
            let percent = 0;
            if (next.special_validity === null) {
                total = 'Unlimited';
                booked = next.registrations.length;
                percent = booked === 0 ? 0 : 100;
            } else {
                let type = next.special_validity.type;
                total = type === 'date' ? 'Unlimited' : parseInt(next.special_validity.amount);
                booked = next.registrations.length;
                percent = type === 'date' ? (booked === 0 ? 0 : 100) : Math.round(booked / total * 100);
            }
            return current + `<tr>
                        <td>
                            ${next.name}
                        </td>
                        <td>
                        <div class="progress">
                        <div class="progress-bar ${color}" role="progressbar" style="width: ${percent}%" aria-valuenow="24" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </td>
                        <td>${booked}</td>
                        <td>${total}</td>
                    </tr>`;
        }, '');

        if (html === '') {
            html = '<tr><td colspan="4" class="text-center">No ticket to show</td></tr>';
        }
        this.$ticketsTable.find('tbody').html(html);
    }

    roomReport(rooms) {
        let roomName = rooms.reduce((current, next) => {
            return current + `<p class="text-muted ml-3 list-item">${next.name}</p>`;
        }, '');
        let html = `<h1 class="font-weight-medium mb-3">${rooms.length} Rooms</h1>${roomName}`;
        this.$roomOverview.html(html);
        this.drawRoomChart(rooms);
    }

    drawRoomChart(rooms) {
        new Chart(this.$roomChart[0], {
            type: 'bar',
            data: {
                labels: rooms.map(room => room.name),
                datasets: [{
                    label: 'Capacity',
                    data: rooms.map(room => room.capacity),
                    backgroundColor: 'rgb(252,154,86)'
                }]
            },
            options: {
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },

                scales: {
                    responsive: true,
                    maintainAspectRatio: true,
                    yAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: true,
                            labelString: 'Capacity'
                        },
                        display: true,
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.03)',
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: true,
                            labelString: 'Rooms'
                        },
                        display: true,
                        barPercentage: 0.4,
                        gridLines: {
                            display: true,
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
    }

    attendeesReport(data) {
        let total = 0;
        let free = 0;
        let premium = 0;
        if (data.length > 0) {
            data.forEach(item => {
                total += item.registrations.length;
                if (item.cost === 0 || item.cost === null)
                    free += item.registrations.length;
                else premium += item.registrations.length;
            })
        }
        let percent = Math.round(free / total * 100);
        this.$totalAttendees.text(total);
        this.$attendeesCostPercent.text((percent || 0) + '% is premium registration');
    }

    articleReport(articles) {
        let total = 0;
        let publish = 0;
        let draft = 0;
        let hidden = 0;
        articles.forEach(article => {
            total++;
            switch (parseInt(article.status)) {
                case 3: {
                    publish++;
                    break;
                }
                case 2: {
                    hidden++;
                    break;
                }
                case 1: {
                    draft++;
                    break;
                }
            }
        });
        this.$totalArticles.text(total);
        this.$totalArticlesDetail.text(`${publish} published, ${draft} draft, ${hidden} hidden`);
    }

    partnersReport(partners) {
        this.$totalPartners.text(partners.length);
    }

    sessionsReport(data) {
        let registrations = [];
        let backgroundColors = [];
        let titles = [];
        data.forEach(session => {
            registrations.push(session.attendees);
            titles.push(session.title);
            backgroundColors.push('#28c195');
        });

        new Chart(this.$sessionDetail[0], {
            type: 'bar',
            data: {
                labels: titles,
                datasets: [
                    {
                        label: 'Registrations',
                        data: registrations,
                        backgroundColor: 'rgba(3, 198, 252)'
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: true,
                            labelString: 'Registrations'
                        },
                        ticks: {
                            min: 0
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: true,
                            labelString: 'Sessions'
                        },
                    }]
                }
            }
        });
    }

    sessionRatingsReport(sessions) {
        let html = sessions.reduce((current, next) => {
            let average = 0;
            let percent = 0;
            let totalRatings = 0;
            if (next.session_ratings.length > 0) {
                totalRatings = next.session_ratings.length;
                average = next.session_ratings.reduce((current, next) => current + next.rate, 0) / totalRatings;
                percent = ((average / 5) * 100).toFixed(2);
            }
            return current + `<tr>
                        <td>${next.title}</td>
                        <td>
                        <div class="row">
                        <div class="col-11">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: ${percent}%" aria-valuenow="${percent}" aria-valuemin="0" aria-valuemax="5"></div>
                            </div>
                        </div>
                        <div class="col-1">${average}/5</div>
                        </div>
                        </td>
                        <td class="text-center">
                            ${totalRatings} ratings
                        </td>
                    </tr>`;
        }, '');

        if (html === '') {
            html = `<tr>
                        <td colspan="3" class="text-center">No session to show</td>
                    </tr>`;
        }

        this.$sessionRatingTable.find('tbody').html(html);
    }

    channelReport(data) {
        let titles = [];
        let rooms = [];
        let sessions = [];
        data.forEach(value => {
            titles.push(value.name);
            rooms.push(value.rooms.length);
            sessions.push(value.sessions.length);
        });

        new Chart(this.$channelChart[0], {
            type: 'bar',
            data: {
                labels: titles,
                datasets: [
                    {
                        label: 'Rooms',
                        data: rooms,
                        backgroundColor: '#ed73fd'
                    },
                    {
                        label: 'Sessions',
                        data: sessions,
                        backgroundColor: '#67fd9c'
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: true,
                            labelString: ''
                        },
                        ticks: {
                            min: 0
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: true,
                            labelString: 'Channels'
                        },
                        ticks: {
                            minRotation: 45
                        }
                    }]
                }
            }
        });
    }

    attendeeRegistrationReport(data) {
        if(this.reportRegistrationChart){
            this.reportRegistrationChart.destroy();
        }
        this.reportRegistrationChart = new Chart(this.$attendeeRegistrationDetail[0], {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Number registrations',
                    data: Object.values(data),
                    backgroundColor: 'rgb(252,13,56)'
                }]
            },
            options: {
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },

                scales: {
                    responsive: true,
                    maintainAspectRatio: true,
                    yAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: true,
                            labelString: 'Number registrations'
                        },
                        display: true,
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.03)',
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: false,
                            labelString: 'Date'
                        },
                        display: true,
                        barPercentage: 0.4,
                        gridLines: {
                            display: true,
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
    }
}

$(() => {
    new EventReport();
});
