define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'products/index' + location.search,
                    add_url: 'products/add',
                    edit_url: 'products/edit',
                    del_url: 'products/del',
                    multi_url: 'products/multi',
                    import_url: 'products/import',
                    table: 'products',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        { checkbox: true },
                        { field: 'id', title: __('Id') },
                        { field: 'image', title: __('Image'), table: table, formatter: Table.api.formatter.image },
                        { field: 'type.title', title: __('Type'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content },
                        { field: 'categories.title', title: __('Categories'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content },
                        { field: 'title', title: __('Title'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content },
                        { field: 'price', title: __('price'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content },
                        { field: 'discount_price', title: __('Discount Price'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content },
                        { field: 'short_description', title: __('Short_description'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content },
                        { field: 'status', title: __('Status'), searchList: { "0": __('Status 0'), "1": __('Status 1') }, formatter: Table.api.formatter.status },
                        { field: 'createtime', title: __('Createtime'), operate: 'RANGE', addclass: 'datetimerange', autocomplete: false, formatter: Table.api.formatter.datetime },
                        { field: 'updatetime', title: __('Updatetime'), operate: 'RANGE', addclass: 'datetimerange', autocomplete: false, formatter: Table.api.formatter.datetime },
                        { field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate }
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
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
