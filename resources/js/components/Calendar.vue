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
                            <form>
                                <div class="form-group">
                                    <label for="event">Event</label>
                                    <input type="text" class="form-control" id="event" v-model="event_data.name">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="dateFrom">From</label>
                                            <input type="date" class="form-control" id="dateFrom" v-model="event_data.from">
                                        </div>
                                        <div class="col-6">
                                            <label for="dateTo">To</label>
                                            <input type="date" class="form-control" id="dateTo" v-model="event_data.to">
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
                                    <button type="submit" class="btn btn-primary" @submit="saveEvent">Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-8">
                            Calendar
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                event_data: {
                    name: "",
                    from: "",
                    to: "",
                    days: {
                        mon: false,
                        tues: false,
                        wed: false,
                        thurs: false,
                        fri: false,
                        sat: false,
                        sun: false,
                    },
                },

            }
        },

        mounted() {
        },

        methods: {
            saveEvent() {
                
            }
        },

        filters: {
            uppercase: (val) => {
                if (!val) return "";

                return _.startCase(val);
            }
        }
    }
</script>
