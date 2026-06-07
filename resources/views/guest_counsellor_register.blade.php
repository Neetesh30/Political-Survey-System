@extends('layouts.app')

@section('content')
<div class="container">
	@if (Session::get('danger'))
		<div class="alert alert-danger">
			{!! Session::get('danger') !!}
		</div>
	@endif
	@if (Session::get('success'))
		<div class="alert alert-success">
			{!! Session::get('success') !!}
		</div>
	@endif
	
	@foreach ($errors->all() as $message)
			<div class="alert alert-danger">
					{{$message}}
				</div>
	@endforeach
	
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger text-white">{{ __('Counsellor Register') }}</div>
                <div class="card-body">
					@if ($projmngr_detail)
						<form method="POST" action="{{ route('storecounsellor') }}">
							@csrf
							<div class="row mb-3">
								<label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

								<div class="col-md-12">
									<input id="id" type="hidden"  name="id" value="{{ $projmngr_detail->uniq_id }}" required>
									<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

									@error('name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="row mb-3">
								<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

								<div class="col-md-12">
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
						
							<div class="row mb-3">
								<label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

								<div class="col-md-12">
									<input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required >

									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
							<div class="row mb-0">
								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-primary">
										{{ __('Register') }}
									</button>
								</div>
							</div>
						</form>
					@else
						<div class="alert alert-danger"> Sorry User is not active or not available . Please try again later.</div>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
