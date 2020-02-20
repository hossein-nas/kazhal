@extends('layouts.master')

@section('header-class','single-header')

@section('content')
<div class="service-body">
	<div class="service-header" style="background-image: {{ $service->color->gradient }}">
		<div class="container">

			<div class="service-title">
				{{ $service->title }}
			</div>

			<div class="service-excerpt">
				{{ $service->excerpt }}
			</div>

			<div class="service-thumbnail">
				<img src="{{ $service->thumbnail->specs[1]['relativepath'] }}" alt="{{ $service->slug }}">
			</div>

		</div>
	</div>

	<div class="container">

		<div class="service-children">

			<!-- <div class="child-service">
				<div class="header">
					<a href="#">
						<div class="title">
						</div>
						<div class="thumbnail">
							<img src="" alt="">
						</div>
					</a>
				</div>
				<div class="body">
					<div class="excerpt">

					</div>

					<div class="features">
						<ul>
							<li>
								<i class="material-icons">check_circle</i>
							</li>
						</ul>

					</div>
				</div>
			</div> -->
			@if($service->hasChild)
				@foreach($service->children as $subService)

					<div class="child-service">
						<div class="header" style="background-image: {{$subService->color->gradient }} ">
							<a href='{{ "/services/$subService->slug/show/" }}' >
								<div class="title">
									{{ $subService-> title }}
								</div>
								<div class="thumbnail">
									<img src="{{ $subService->thumbnail->specs[0]['relativepath'] }}" alt="{{ $subService->slug }}">
								</div>
								@if( strlen($subService->price) > 0 )
									<span class="price gen-price" style="background-color : {{ $subService->color->contrast_color}}" data-price="{{ $subService->price }}">
									</span>
								@else
									<span class="price no-value" style="background-color : {{ $subService->color->contrast_color}}">
										برای مشاوره تماس بگیرید
									</span>
								@endif
							</a>
						</div>
						<div class="body">
							<div class="excerpt">
								{{ $subService->excerpt}}
							</div>

							<div class="features">
								<ul>
									@foreach($subService->features as $feature )
										<li>
											<i class="material-icons">check_circle</i>
											{{ $feature }}
										</li>
									@endforeach
								</ul>

							</div>
						</div>
					</div>
				@endforeach
			@endif

		</div>

		<div class="service-content">
			<div class="label">
				درباره‌ی ::
				{{ $service->title }}
			</div>
			<div class="body">
				{!! $service->content !!}
			</div>
		</div>
	</div>
</div>

@endsection