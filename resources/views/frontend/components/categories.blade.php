 <div class="sidebar-widget">
     <h4 class="widget-title">Categories</h4>
     <div class="list-group list-group-flush">

         @foreach($categories as $category)
         <a href="{{ route('frontend.posts',  ['category' => $category->id]) }}"
             class="text-decoration-none ">
             <div class="d-flex align-items-center mb-2">
                 @if($category->image)
                 <div class="col-3">
                     <img src="{{ asset('assets/categories/' . $category->image) }}"
                         class="img-fluid rounded"
                         alt="{{ $category->name }}"
                         style="height: 60px; width: 60px; border-radius:50%; object-fit: cover;">
                 </div>
                 @endif


                 <div class=" d-flex {{ $category->image ? 'col-8' : 'col-12' }}">

                     <h6 class="mb-1 me-2">

                         {{ $category->name }}

                     </h6>
                     <small class="text-muted ms-auto bg-primary rounded px-2" style="color:white !important">
                         Posts: {{ $category->posts()->where('status', 'published')->count() }}
                     </small>

                 </div>
             </div>
         </a>
         <hr>
         @endforeach
     </div>
 </div>