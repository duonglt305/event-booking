class Registration {
    constructor() {
        this.$registrationtDatatable = $('#registration_table');
        this.$dropdownPending = $('#dropdown-pending');
        this.$dropdownPaid = $('#dropdown-paid');
        this.$dropdownMenuOutlineButton1 = $('#dropdownMenuOutlineButton1');
        this.status = this.$dropdownPaid.data('status');
        this.init();
    }

    init() {
        this.initTable();

        this.$dropdownPaid.click(event => {
            let status = this.$dropdownPaid.data('status');
            this.$dropdownMenuOutlineButton1.text(this.$dropdownPaid.text());
            this.status = status;
            this.$registrationtDatatable.DataTable().ajax.url(this.$registrationtDatatable.data('url') + '?status=' + this.resolveStatus()).load();
        });

        this.$dropdownPending.click(event => {
            let status = this.$dropdownPending.data('status');
            this.$dropdownMenuOutlineButton1.text(this.$dropdownPending.text());
            this.status = status;
            this.$registrationtDatatable.DataTable().ajax.url(this.$registrationtDatatable.data('url') + '?status=' + this.resolveStatus()).load();
        })

    }

    initTable() {
        this.$registrationtDatatable.DataTable({
            dom: "<'row'" +
                "<'col-lg-6 col-12'l>" +
                "<'col-lg-6 col-12'f>" +
                ">" +
                "<'row'<'col-12'<'table-responsive't>>>" +
                "<'row'<'col-12 col-lg-6'i><'col-12 col-lg-6'p>>",
            serverSide: true,
            ajax:
                {
                    method: 'get',
                    url: this.$registrationtDatatable.data('url') + '?status=' + this.resolveStatus(),
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        }
                }
            ,
            pageLength: 100,
            columns: [
                {
                    title: '#',
                    name: 'DT_RowIndex',
                    data: 'DT_RowIndex',
                    class: 'text-center py-1',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'Full name',
                    name: 'full_name',
                    data: 'full_name',
                    class: 'text-center'
                },

                {
                    title: 'Sessions attended',
                    name: 'session_attended',
                    data: 'session_attended',
                    class: 'text-left pl-2 pr-2'
                },
                {
                    title: 'Registered at',
                    name: 'registered_at',
                    data: 'registered_at',
                    class: 'text-center'
                },
                // {
                //     title: 'Status',
                //     name: 'status',
                //     data: 'status',
                //     class: 'text-center'
                // },
                // {
                //     title: 'Time',
                //     name: 'time',
                //     data: 'time',
                //     class: 'text-center'
                // },
                // {
                //     title: 'Action',
                //     name: 'action',
                //     data: 'action',
                //     class: 'text-center'
                // },
            ]
        });
    }

    resolveStatus() {
        return this.status;
    }

}

$(() => {
    new Registration();
});
