<template>
    <div class="col-12 justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h4>Calendar</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <form @submit.prevent="saveEvent()">
                                <div class="form-group">
                                    <label for="event">Event</label>
                                    <input type="text" class="form-control" id="event" required v-model="event_data.name">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="dateFrom">From</label>
                                            <input type="date" class="form-control" id="dateFrom" required v-model="event_data.from">
                                        </div>
                                        <div class="col-6">
                                            <label for="dateTo">To</label>
                                            <input type="date" class="form-control" id="dateTo" required v-model="event_data.to">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <div class="form-check form-check-inline col" v-for="(bool, day) in event_data.days" >
                                        <input class="form-check-input" type="checkbox" :id="day" v-model="event_data.days[day]">
                                        <label class="form-check-label" :for="day">{{day | uppercase }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" :disabled="saving">
                                        <span v-if="!saving">Save</span>
                                        <span v-else>Saving...</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-8" v-if="!loading">
                            <div class="row">
                                <div class="col-12">
                                    <h2>{{data.month}} {{data.year}}</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div v-for="data, date in data.events">
                                        <div class="row">
                                            <div class="col-3 mt-3 mb-3">{{date | monthYear}}</div>
                                            <div class="col-9 mt-3 mb-3">
                                                <div v-if="data">
                                                    {{data.event.name}}        
                                                </div>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="col-8">
                            <div class="alert alert-info">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'vuejs-noty/dist/vuejs-noty.css';

    export default {
        data() {
            return {
                event_data: {
                    name: "",
                    from: "",
                    to: "",
                    days: {
                        mon: false,
                        tue: false,
                        wed: false,
                        thu: false,
                        fri: false,
                        sat: false,
                        sun: false,
                    },
                },

                data: [],

                saving: false,
                loading: true,
            }
        },

        mounted() {
            this.getEvents();
        },

        methods: {
            getEvents(filter_date = false) {
                this.loading = true;
                var date_params = {};
                if (filter_date) {
                    date_params['from'] = this.event_data.from;
                    date_params['to'] = this.event_data.to;
                }

                axios.get('/api/get-events', {params: date_params}).then(({data}) => {
                    this.data = data;
                    this.loading = false;
                });
            },
            saveEvent() {
                this.saving = true;
                axios.post('/api/save-event', this.event_data).then(({data}) => {
                    this.getEvents(true);
                    this.saving = false;
                    this.$noty.success("Event successfully saved!");
                });
            },
        },

        filters: {
            uppercase: (val) => {
                if (!val) return "";

                return _.startCase(val);
            },
            monthYear: (val) => {
                if (!val) return "";
                return moment(val).format('D ddd');
            }
        }
    }
</script>
