@extends('layouts.master')

@section('header-class','mini-header')

@section('content')
<div class="container">
	<section id="post">
		<article class="head-section">
			<div class="title-area">
				<div class="title">
					<a href="/posts/{{$post->slug}}/show/">{{ $post-> title }}</a>
				</div>
				<div class="details">
					<div class="author">
						<div class="thumb">
							<img src="{{ $post->author->thumb->specs[0]['relativepath'] }}" alt="">
						</div>
						<div class="name">
							<span>ارسال شده توسط: </span>
							{{ $post->author->firstname . " " . $post->author->lastname }}
							<span class="role">{{ $post->author->role->title }}</span>
						</div>
					</div>
					<div class="categories">
						@if ( $post->categories->count() )
							<ul>
								@foreach( $post->categories as $cat)
									<li> <a href="/posts/categories/{{$cat->title}}/show/">{{ $cat->title }} </a></li>
								@endforeach
							</ul>
						@endif
					</div>
				</div>
			</div>
			<div class="thumbnail-area">
				<img src="{{ $post->thumb->specs[0]['relativepath'] }}" alt="{{$post->slug}}">
				<div class="info">
					<div class="created_at gen-date" data-date="{{$post->created_at_ts}}">
						{{ $post->created_at }}
					</div>
					<div class="view-count">
						2342
					</div>
				</div>
			</div>
		</article>
		<article class="body-section">
			{!! $post->content !!}
		</article>
		<article class="author">

		</article>
	</section>
	<section class="comments-section">
		<div class="new-comment">
			<div class="head-section">
					<span>ارسال دیدگاه </span>
					<span class="reply-to ">
					</span>
			</div>

			<form action="/comments/add-new/" method="POST" class="form">
				<input type="hidden" name="parent_id" value="" class="parent_id" />

				<div class="form-control required">
					<div class="label">
						متن دیدگاه  را بنویسید :
					</div>
					<textarea class="input" name="comment-content" id="cm-content"   rows="5"></textarea>
				</div>

				<div class="form-group">
					<div class="form-control required">
						<div class="label">
							نــام :
						</div>
						<input type="text" class="input" id="cm-name" placeholder="" >
					</div>
					<div class="form-control">
						<div class="label">
							ایمیل :
						</div>
						<input type="email" class="input" id="cm-email" placeholder="" dir="ltr" >
					</div>
				</div>

				<div class="form-control submit">
					<button name="submit" type="submit" id="submit"> ارسال دیدگاه </button>
				</div>

			</form>
		</div>
	</section >
</div>
@endsection
