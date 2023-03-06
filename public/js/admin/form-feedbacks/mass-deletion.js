(function () {
    Admin.Events.on('datatables::draw', function () {
        if (document.querySelector('#mass-deletion-btns')) return;

        const html = `<div id="mass-deletion-btns">
            <button type="button" class="btn btn-danger" style="display: none;" data-action="delete-selected">
                <i class="fas fa-trash-alt"></i> Удалить выделенное
            </button>
            <button type="button" class="btn btn-danger" style="display: none;" data-action="delete-all">
                <i class="fas fa-trash-alt"></i> Удалить все
            </button>
        </div>`;

        document.querySelector('.dataTables_filter').insertAdjacentHTML('beforeend', html);

        const
            deleteSelectedBtn = document.querySelector('#mass-deletion-btns [data-action="delete-selected"]'),
            deleteAllBtn = document.querySelector('#mass-deletion-btns [data-action="delete-all"]');

        // Удаление всех записей
        deleteAllBtn.addEventListener('click', function () {
            Admin.Messages.confirm('Вы действительно хотите удалить все записи?').then(function (result) {
                if (result.isConfirmed) {
                    window.location = '/admin/form_feedbacks/all_delete';
                }
            });
        });

        // Удаление выделенных записей
        deleteSelectedBtn.addEventListener('click', function () {
            Admin.Messages.confirm('Вы действительно хотите удалить выделенные записи?').then(function (result) {
                if (result.isConfirmed) {
                    const ids = Array.from(document.querySelectorAll('[name="_id[]"]:checked')).map(function (item) {
                        return item.value;
                    });

                    window.location = `/admin/form_feedbacks/${ids.join(',')}/selected_delete`;
                }
            });
        });

        // Управление видимостью кнопок удаления
        (function showBtns() {
            const
                checkboxes = document.querySelectorAll('[name="_id[]"]'),
                checkedCheckboxes = document.querySelectorAll('[name="_id[]"]:checked');

            if (checkedCheckboxes.length) {
                deleteAllBtn.style.display = 'none';
                deleteSelectedBtn.style.display = 'inline-block';
            } else if (checkboxes.length) {
                deleteAllBtn.style.display = 'inline-block';
                deleteSelectedBtn.style.display = 'none';
            } else {
                deleteAllBtn.style.display = 'none';
                deleteSelectedBtn.style.display = 'none';
            }

            setTimeout(showBtns, 250);
        })();
    });
})();
