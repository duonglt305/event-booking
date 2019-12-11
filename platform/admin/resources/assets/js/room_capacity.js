import axios from 'axios';

class RoomCapacity {
    constructor() {
        this.$roomCapacity = $('#event_room_capacity');
        this.init();
    }

    async getDataMapped() {
        let sessions = await this.getData();
        let registrations = [];
        let capacities = [];
        let backgroundColors = [];
        let titles = [];
        sessions.forEach(session => {
            registrations.push(session.attendees);
            titles.push(session.title);
            capacities.push(session.room_capacities);
            if (session.room_capacities < session.attendees) {
                backgroundColors.push('#fa555f');
            } else {
                backgroundColors.push('#28c195');
            }
        });
        return {
            'titles': titles,
            'registrations': registrations,
            'capacities': capacities,
            'backgroundColors': backgroundColors,
        }
    }

    async init() {
        let ctx = this.$roomCapacity[0].getContext('2d');
        let data = await this.getDataMapped();
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.titles,
                datasets: [
                    {
                        label: 'Attendees',
                        data: data.registrations,
                        backgroundColor: data.backgroundColors
                    },
                    {
                        label: 'Capacity',
                        data: data.capacities,
                        backgroundColor: '#007bfd'
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            fontSize: 20,
                            display: true,
                            labelString: 'Capacity'
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
                        ticks: {
                            minRotation: 45
                        }
                    }]
                }
            }
        });

    }

    getData() {
        let action = this.$roomCapacity.data('url');
        return axios.post(action)
            .then(res => {
                return Promise.resolve(res.data.sessions);
            })
            .catch(err => {
                Promise.reject(err);
            });
    }
}


$(() => new RoomCapacity());


