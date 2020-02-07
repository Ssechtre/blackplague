@extends('layouts.app')

@section('title', 'Create' )

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header card-header-primary">
                  <h4 class="card-title ">Edit</h4>
                  <p class="card-category"> Here is a subtitle for this table</p>
                </div>
                <div class="card-body">
                	<form method="post" action="{{ url($controller.'/'.$data->primary_key) }}" method="PUT">
						<?php foreach($fillables as $key => $value): ?>
							<div class="form-group">
								
								<?php if(!in_array($value, $fields['excludes'])): ?>
									<label class="control-label">
									<?= (array_key_exists($value, $fields['text_replace'])) ? $fields['text_replace'][$value] : str_replace('_', ' ', ucfirst($value)) ?>
										
									</label>
								<?php endif ?>

								<?php if(in_array($value, $fields['checkboxes'])): ?>
									<input type="checkbox" class="form-control" name="{{ $value }}" value="<?= $data->$value ?>">
								<?php elseif(in_array($value, $fields['dates'])): ?>
									<input type="date" class="form-control" name="{{ $value }}" value="<?= $data->$value ?>">
								<?php elseif(in_array($value, $fields['textareas'])): ?>
									<textarea class="form-control" name="{{ $value }}"><?= $data->$value ?></textarea>
								<?php elseif(array_key_exists($value, $fields['dropdowns'])): ?>
									{!! Form::select($value, $fields['dropdowns'][$value], $data->$value, array('class' => 'form-control', )); !!}	
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
						<?php endforeach; ?>
			
						<div class="form-group">
							<button class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
						</div>
					</form>
                </div>
			</div>
		</div>
	</div>
</div>

@endsection