<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <form action="{{route('admin.cache.clear')}}" method="post">
                {{ csrf_field() }}

                <div class="box-header with-border">
                    <h3 class="box-title">Очистка кэша</h3>
                </div>

                <div class="panel panel-default">
                    <div class="form-elements">
                        <div class="panel-body">
                            <div class="form-elements">
                                <div class="panel">
                                    <div class="form-group form-element-checkbox">
                                        <div class="checkbox">
                                            <label>
                                                <input id="select-all" name="select-all" onclick="toggle(this);" type="checkbox" value="0">
                                                Все типы кэша
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-element-checkbox">
                                    <div class="checkbox">
                                        <label>
                                            <input id="cache" name="cache" type="checkbox" value="1">
                                            Общий кэш
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group form-element-checkbox">
                                    <div class="checkbox">
                                        <label>
                                            <input id="config" name="config" type="checkbox" value="1">
                                            Кэш конфигураций
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group form-element-checkbox">
                                    <div class="checkbox">
                                        <label>
                                            <input id="view" name="view" type="checkbox" value="1">
                                            Кэш страниц
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group form-element-checkbox">
                                    <div class="checkbox">
                                        <label>
                                            <input id="route" name="route" type="checkbox" value="1">
                                            Кэш роутов
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-buttons panel-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Очистить кэш
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
</script>