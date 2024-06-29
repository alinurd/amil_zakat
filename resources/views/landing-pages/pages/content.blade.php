<x-app-layout layout="landing" :isHeader1=true>
    <x-landing-pages.widgets.sub-header subTitle="Blog" subBreadcrume="Blog" />
    <div class="inner-card-box">
        <div class="container">
            <div class="row">
                 @foreach ($data as $k=> $q)
                 <div class="col-lg-3 col-md-3 col-sm-3">
                    <x-landing-pages.widgets.blog-1 blogImage="blog/{{$q->media}}" blogDate="{{$q->created_at}}"
                        blogTitle="{{$q->name_content}}"
                        blogAuther="{{$q->media}}"
                        blogDescription="{{$q->descriptions}}" />
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
