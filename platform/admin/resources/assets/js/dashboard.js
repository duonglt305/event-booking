import Axios from 'axios';
class Dashboard {
    constructor() {
        this.$totalEvents = $('#total-events');
        this.$totalEventInfoUnComplete = $('#total-event-info-un-complete');
        this.$totalOngoingEvents = $('#total-ongoing-events');
        this.$totalUpcomingEvent = $('#total-upcoming-event');
        this.$totalTookPlaceEvents = $('#total-took-place-events');
        this.$mostEventRatingTable = $('#most-event-rating-table');
        this.$eventRegistrationDetail = $('#event-registration-detail');
        this.totalEventInfoActivePending = $('#total-event-info-active-pending');
        this.init();
    }

    init() {
        this.getData();
    }

    getData() {
        Axios.get('/organizer/dashboard-data').then(
            res => {
                let {
                    total_events,
                    took_place_events,
                    upcoming_events,
                    ongoing_events,
                    total_un_complete_events,
                    averages,
                    registrations,
                    active_event,
                    pending_event
                } = res.data;

                this.$totalEvents.text(total_events);
                this.$totalEventInfoUnComplete.text(`${total_un_complete_events} events is un complete info`);
                this.totalEventInfoActivePending.text(`${active_event} active, ${pending_event} pending`);
                this.$totalOngoingEvents.text(ongoing_events);
                this.$totalUpcomingEvent.text(upcoming_events);
                this.$totalTookPlaceEvents.text(took_place_events);

                let html = averages.reduce((current, next) => {
                    return current + `
                        <tr>
                            <td>${next.title}</td>
                            <td>
                            <div class="row">
                            <div class="col-11">
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: ${next.percent}%" aria-valuenow="${next.percent}" aria-valuemin="0" aria-valuemax="5"></div>
                                </div>
                            </div>
                            <div class="col-1">${next.average}/5</div>
                            </div>
                            </td>
                            <td class="text-center">
                                ${next.total_ratings} ratings
                            </td>
                        </tr>
                    `;
                }, '');

                if (html === '') {
                    html = `<tr><td colspan="3" class="text-center">No Data to show</td></tr>`;
                }

                this.$mostEventRatingTable.find('tbody').html(html);

                new Chart(this.$eventRegistrationDetail[0], {
                    type: 'bar',
                    data: {
                        labels: registrations.map(registration => registration.event_name),
                        datasets: [{
                            label: 'Number registrations',
                            data: registrations.map(registration => registration.registrations.length),
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
        )
    }
}

$(() => {
    new Dashboard();
});
