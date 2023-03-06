<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<form action="{{route('admin.settings.post')}}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="box-header with-border">
					<h3 class="box-title">Системные настройки</h3>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<table id="env_editor_table" class="table table-striped">
						<thead>
							<tr>
								<th class="row-header">
									Ключ
								</th>
								<th class="row-header">
									Значение
								</th>
								<th class="row-header"></th>
							</tr>
						</thead>

						<thead class="table table-striped table table-striped">
							<tr></tr>
						</thead>

						<tbody>
							@foreach($settings as $settingName => $settingValue)
								<tr>
									<td class="row-link">
										<div class="form-control" style="background-color:unset;">{{ $settingName }}</div>
									</td>
									<td class="row-datetime">
										<input type="text" name="{{ $settingName }}" value="{{ $settingValue }}" class="form-control">
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<div class="panel-footer">
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-check"></i>
							Сохранить
						</button>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>

