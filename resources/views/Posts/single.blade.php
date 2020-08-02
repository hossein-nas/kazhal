@extends('layouts.master')

@section('header-class','mini-header')

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/intersection-observer@0.7.0/intersection-observer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.1.0/dist/lazyload.min.js"></script>
<script>
var lazyLoadInstance = new LazyLoad({
    // Your custom settings go here
});
</script>
@endsection

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
				<img class="lazy" 
					 src="{{ $post->thumb->specs[0]['relativepath'] }}"
					 data-srcset="{{ $post->thumb->src_set }}"
					 alt="{{$post->slug}}">
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
		<article id="comments-index">
			@foreach($comments as $comment)
				<div class="comments-item">
					<div class="head-section">
						<span class="avatar">
							<img src="/images/unregistered.svg" alt="">
						</span>
						<span class="user-name">
							{{ $comment->name }}
						</span>
						<span class="time">
							{{ $comment->local_time }}
						</span>
					</div>
					<div class="body">
						@if($comment->parent)
						<div class="replier">
							<div class="header">{{ $comment->parent->name }}</div>
							<div class="body">
								{{ $comment->parent->body }}		
							</div>
						</div>
						@endif
					{{ $comment->body }}
					</div>

					<div class="footer">
						<span class="reply-btn" data-reply-id="{{ $comment->id }}">
							<i class="material-icons">reply</i>
							پاسخ به دیدگاه
						</span>
					</div>
				</div>
			@endforeach
		</article>
		<div class="new-comment">
			<div class="head-section">
					<span>ارسال دیدگاه </span>
					<span class="reply-to">
					</span>
			</div>
			<form action="/comments/add-new/" method="POST" class="form">
				<input type="hidden" name="parent_id" value="" class="parent_id"  />
				<input type="hidden" name="post_id" value="{{$post->id}}" class="post_id"  />

				<div class="form-control required">
					<div class="label">
						متن دیدگاه  را بنویسید :
					</div>
					<textarea class="input" name="body" id="cm-content"   rows="5" data-tippy-content="hey you"></textarea>
				</div>

				<div class="form-group">
					<div class="form-control required">
						<div class="label">
							نــام :
						</div>
						<input type="text" name="name" class="input" id="cm-name" placeholder="" >
					</div>
					<div class="form-control">
						<div class="label">
							ایمیل :
						</div>
						<input type="email" name="email" class="input" id="cm-email" placeholder="" dir="ltr" >
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
