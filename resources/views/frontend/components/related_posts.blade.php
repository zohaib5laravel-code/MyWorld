 <div class="sidebar-widget">
     <h4 class="widget-title">Related Posts</h4>
     <div class="list-group list-group-flush">

         @foreach($relatedPosts as $relatedPost)
         <div class="d-flex mb-2">
             @if($relatedPost->featured_image)
             <div class="col-4">
                 <img src="{{ asset('assets/posts/' . $relatedPost->featured_image) }}"
                     class="img-fluid rounded"
                     alt="{{ $relatedPost->title }}"
                     style="height: 80px; object-fit: cover;">
             </div>
             @endif


             <div class="{{ $relatedPost->featured_image ? 'col-8' : 'col-12' }}">
                 <div class="p-2">
                     <h6 class="mb-1">
                         <a href="{{ route('frontend.post', $relatedPost->slug) }}"
                             class="text-decoration-none text-dark">
                             {{ Str::limit($relatedPost->title, 40) }}
                         </a>
                     </h6>
                     <small class="text-muted">
                         {{ date('M d, Y', strtotime($relatedPost->published_at)) }}
                     </small>
                 </div>
             </div>
         </div>

         @endforeach
     </div>
 </div>