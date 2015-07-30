webix.ready(function(){
    var groupParams = {
        campaign_id : '# Кампании',
        name: 'Название кампании',
        sex: 'Пол',
        age_from: 'Возраст от',
        age_to: 'Возраст до',
        budget_limit: 'Лимит бюджета',
        payment_type: 'Тип оплаты',
        title: 'Заголовок объявления'
    };
    for (var i in groupParams)
    {
        $('#group').append('<option value="' + i + '">' + groupParams[i] + '</option>');
    }

    $('#group').change(function()
    {
        if ( ! $(this).val())
        {
            return ;
        }

        $('#table').hide();
        $('#table_2').empty();
        $('#table_3').empty();
        var grid = webix.ui({
            container:"table_2",
            view:"datatable",
            columns:[
                { id:$(this).val(),	header:groupParams[$(this).val()], width: 350 },
                { id:"shows",	header:"Показов",  width: 120 },
                { id:"clicks",	header:"Кликов",  width: 120 },
                { id:"costs",	header:"Стоимость",  width: 120 },
                {id: 'cpc', header: 'CPC', width: 120},
            ],
            tooltip: true,
            autowidth:true,
            select: 'row',
            on: {
                "onItemClick": function (id, e, node)
                {
                    $('#table_3').empty();
                    var item = this.getItem(id);
                    var gridb = webix.ui({
                        container:"table_3",
                        view:"datatable",
                        columns:[
                            { id:"campaign_id",	header:"ID", width: 100 },
                            { id:"name",	header:"Название кампании",  width: 350 },
                            { id:"sex",	header:"Пол",   width: 50 },
                            { id:"age_from",	header:"Возраст от",  width: 120 },
                            { id:"age_to",	header:"Возраст до",  width: 120 },
                            { id:"budget_limit",	header:"Лимит",  width: 120 },
                            { id:"payment_type",	header:"Тип оплаты",  width: 120 },
                            { id:"ad_id",	header:"# Объявления",  width: 150 },
                            { id:"title",	header:"Заголовок объявления",  width: 250 },
                            { id:"shows",	header:"Показов",  width: 120 },
                            { id:"clicks",	header:"Кликов",  width: 120 },
                            { id:"costs",	header:"Стоимость",  width: 120 },
                        ],
                        tooltip: true,
                        autowidth:true,

                        data: item.rows
                    });
                }
            },
            url: 'data.php?group=' + $(this).val()
        });
    });
    grida = webix.ui({
        container:"table",
        view:"datatable",
        columns:[
            { id:"campaign_id",	header:"ID", width: 100 },
            { id:"name",	header:"Название кампании",  width: 350 },
            { id:"sex",	header:"Пол",   width: 50 },
            { id:"age_from",	header:"Возраст от",  width: 120 },
            { id:"age_to",	header:"Возраст до",  width: 120 },
            { id:"budget_limit",	header:"Лимит",  width: 120 },
            { id:"payment_type",	header:"Тип оплаты",  width: 120 },
            { id:"ad_id",	header:"# Объявления",  width: 150 },
            { id:"title",	header:"Заголовок объявления",  width: 250 },
            { id:"shows",	header:"Показов",  width: 120 },
            { id:"clicks",	header:"Кликов",  width: 120 },
            { id:"costs",	header:"Стоимость",  width: 120 },
        ],
        tooltip: true,
        autowidth:true,

        url: 'data.php'
    });
});