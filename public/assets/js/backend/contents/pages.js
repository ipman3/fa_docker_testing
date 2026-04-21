define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'contents/pages/index' + location.search,
                    add_url: 'contents/pages/add',
                    edit_url: 'contents/pages/edit',
                    del_url: 'contents/pages/del',
                    multi_url: 'contents/pages/multi',
                    import_url: 'contents/pages/import',
                    table: 'pages',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                fixedColumns: true,
                fixedRightNumber: 1,
                pagination: false,
                escape: false,
                columns: [
                    [
                        { checkbox: false },
                        { field: 'id', title: __('Id') },
                        {
                            field: 'title',
                            title: __('Title'),
                            align: 'left',
                            operate: 'LIKE', table: table,
                        },
                        { field: 'seo_image', title: __('SEO Image'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image, visible: function (row) { return row.parent_id == 0; } },
                        { field: 'seo_title', title: __('SEO Title'), operate: "LIKE", visible: function (row) { return row.parent_id == 0; } },
                        { field: 'seo_keyword', title: __('SEO Keyword'), operate: "LIKE", formatter: Table.api.formatter.content, visible: function (row) { return row.parent_id == 0; } },
                        { field: 'status', title: __('Status'), searchList: { "0": __('Status 0'), "1": __('Status 1') }, formatter: Table.api.formatter.status },
                        // { field: 'parent_id', title: __('Parent_id') },
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate,
                            align: 'right',
                            buttons: [
                                {
                                    name: 'addtext',
                                    text: 'Text',
                                    classname: 'btn btn-info btn-xs btn-dialog',
                                    icon: 'fa fa-plus',
                                    url: 'contents/pages/addtext/parent_id/{ids}',
                                    visible: function (row) {
                                        return row.parent_id == 0;
                                    },
                                },
                                {
                                    name: 'addimage',
                                    text: 'Image',
                                    classname: 'btn btn-info btn-xs btn-dialog',
                                    icon: 'fa fa-plus',
                                    url: 'contents/pages/addimage/parent_id/{ids}',
                                    visible: function (row) {
                                        return row.parent_id == 0;
                                    },
                                },
                                {
                                    name: 'addeditor',
                                    text: 'Editor',
                                    classname: 'btn btn-info btn-xs btn-dialog',
                                    icon: 'fa fa-plus',
                                    url: 'contents/pages/addeditor/parent_id/{ids}',
                                    visible: function (row) {
                                        return row.parent_id == 0;
                                    },
                                },
                                {
                                    name: 'edit',
                                    text: '',
                                    classname: 'btn btn-success btn-xs btn-dialog',
                                    icon: 'fa fa-pencil',
                                    url: 'contents/pages/edit/ids/{ids}',
                                    visible: function (row) {
                                        return row.parent_id == 0;
                                    },
                                }
                            ]
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        addtext: function () {
            Controller.api.bindevent();
        },
        addimage: function () {
            Controller.api.bindevent();
        },
        addeditor: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
