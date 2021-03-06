@extends('layouts.app')

@section('title', 'Lists' )

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header card-header-primary">
                  <h4 class="card-title ">List of {{ $controller }}</h4>
                  <p class="card-category">Shows lists of {{ $controller }} by date created in descending order</p>
                </div>
                <div class="card-body">
                	<div class="row">
                		<form method="GET" class="col-md-6" action="{{ url($controller) }}">
                			<input type="hidden" name="search" value="true">
                			@if(isset($filters['text']) && count($filters['text']) > 0)
	                			@foreach($filters['text'] as $key => $value)
	                			<div class="form-group mt-3">
	                				<label class="control-label">Search</label>
	                				<input type="text" 
	                				name="{{ $value }}"
	                				class="form-control" 
	                				placeholder="Search {{ implode(', ',$filters['text']) }}"
	                				value="<?= isset($_GET[$value]) ? $_GET[$value] : '' ?>">
	                			</div>
	                			@endforeach
                			@endif

                			@if(isset($filters['dropdown']) && count($filters['dropdown']) > 0)
                				@foreach($filters['dropdown'] as $key => $value)
	                			<div class="form-group">
	                				<label class="control-label">Filter by {{ $value['label'] }}</label>
	                				<select class="form-control" name="{{ $key }}">
	                					<option value="">- Select {{ $value['label'] }} -</option>
	                					@foreach($value['data'] as $k => $v)
		                				<option value="{{ $k }}" 
		                				<?= (isset($_GET[$key]) && $_GET[$key] != '' && $_GET[$key] == $k) ? 'selected="selected"' : '' ?>>
		                				{{ $v }}
		                				</option>
		                				@endforeach
		                			</select>
	                			</div>
                				@endforeach
                			@endif
                		
		            		@if($filters['text'] || $filters['dropdown'])
		            		<button class="btn btn-primary"><i class="material-icons">search</i> Search</button>
		            		@endif
                		</form>

                		<div class="col-lg-3 offset-lg-3 col-sm-12">
                			<a href="{{ url($controller.'/create') }}"><button class="btn btn-success pull-right"><i class="fa fa-plus fa-fw"></i> Add new {{ $controller }}</button></a>
                		</div>
                	</div>

					<div class="row mt-3">
						<div class="col-sm-12">
							<table class="table table-bordered table-hover table-striped table-responsive-sm">
								<thead>
									<tr>
										<?php foreach($columns as $key => $value): ?>
											@if(!in_array($value, $excludes))
												@if(!in_array($value, $fields['hiddens']))
													<th>
														<?= (isset($fields['text_replace']) && array_key_exists($value, $fields['text_replace'])) ? str_replace('_',' ',ucfirst($fields['text_replace'][$value])) : str_replace('_',' ',ucfirst($value)) ?></th>
												@endif
											@endif
										<?php endforeach; ?>

										@if($relationships)
											<?php foreach($relationships as $rkey => $rval) : ?>
												<th><?= $rval['name'] ?></th>
											<?php endforeach; ?>
										@endif

										@if($with_actions)
											<th>Action</th>
										@endif
									</tr>
								</thead>
								<tbody>
									<?php foreach($data as $key => $value): ?>
			
										<tr>
											<?php foreach($columns as $col_key => $col_val): ?>
												@if(!in_array($col_val, $excludes))
													@if(!in_array($col_key, $fields['hiddens']))
													<td>
														<?php 
														if($col_val == 'created_at' || $col_val == 'updated_at'){
															echo date('F d, Y H:i:s', strtotime($value[$col_val]));
														}elseif(array_key_exists($col_val, $column_values)){
															echo $column_values[$col_val][$value[$col_val]];
														}else{
															$str = substr($value[$col_val], 0, 30);
															$dots = (strlen($value[$col_val]) > 30) ? '...' : '';
															echo $str.$dots;
														}
														?>
													</td>
													@endif
												@endif
											<?php endforeach; ?>

											@if($relationships)
												<?php foreach($relationships as $rkey => $rval) : ?>
													<th><?= $value[$rkey][$rval['column']] ?></th>
												<?php endforeach; ?>
											@endif

											<?php $url = url($controller.'/'.$value[$primary_key]).'/edit' ?>

											@if($with_actions)
												<td>
													<a href="<?= $url ?>"><button class="btn btn-default btn-xs pull-left"><i class="fa fa-search"></i></button></a>
												</td>
											@endif
										</tr>
									<?php endforeach; ?>
									
								</tbody>
							</table>

							{{ $data->links() }}
						</div>
					</div>
                </div>
			</div>
		</div>
	</div>
</div>

@endsection