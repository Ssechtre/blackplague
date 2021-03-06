@extends('layouts.app')

@section('title', 'Edit' )

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header card-header-primary">
                  <h4 class="card-title ">Edit</h4>
                  <p class="card-category">Edit valuable information here</p>
                </div>
                <div class="card-body mt-4">
                	<form method="POST" action="{{ url($controller.'/'.$data->id) }}">
                		@csrf
						<?php foreach($fillables as $key => $value): ?>
							@method('PUT')							
							<?php if(!in_array($value, $fields['excludes'])): ?>
								<div class="form-group mt-4">								
									
									<label class="control-label">
									<?= (array_key_exists($value, $fields['text_replace'])) ? $fields['text_replace'][$value] : str_replace('_', ' ', ucfirst($value)) ?>											
									</label>
									
									<?php if(in_array($value, $fields['checkboxes'])): ?>
										<input type="checkbox" class="form-control" name="{{ $value }}" value="<?= $data->$value ?>">
									<?php elseif(in_array($value, $fields['dates'])): ?>
										<input type="date" class="form-control" name="{{ $value }}" value="<?= $data->$value ?>">
									<?php elseif(in_array($value, $fields['textareas'])): ?>
										<textarea class="form-control" name="{{ $value }}"><?= $data->$value ?></textarea>
									<?php elseif(array_key_exists($value, $fields['dropdowns'])): ?>
										<select class="form-control" name="user_type">
											<option value="">- Select -</option>
											@foreach($fields['dropdowns'][$value] as $dk => $dv)
											<option value="{{ $dk }}" {{ ($data->$value == $dk) ? 'selected' : '' }}>{{ $dv }}</option>
											@endforeach
										</select>	
									<?php elseif(in_array($value, $fields['hiddens'])): ?>
										<input type="hidden" class="form-control" name="{{ $value }}" value="<?= $data->$value ?>">
									<?php elseif(in_array($value, $fields['times'])): ?>
										<input type="text" id="timepicker" class="form-control" name="{{ $value }}" value="<?= $data->$value ?>">
									<?php elseif(in_array($value, $fields['excludes'])): ?>
										{{-- do nothing --}}
									<?php else: ?>
										<input type="text" class="form-control" name="{{ $value }}" value="<?= ($value != 'password') ? $data->$value : '' ?>">
									<?php endif; ?>													
								</div>
							<?php endif ?>
						<?php endforeach; ?>
			
						<div class="form-group">
							<a class="btn btn-info" href="{{ url($controller) }}"><i class="fa fa-arrow-left"></i> Go back</a>
							<button class="btn btn-success pull-right"><i class="fa fa-save"></i> Save</button>
						</div>
					</form>
                </div>
			</div>
		</div>
	</div>
</div>

@endsection