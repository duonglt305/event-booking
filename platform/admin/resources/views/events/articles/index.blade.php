<div class="row">
    <div class="col-12">
        <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
            <div>
                <h4 class="title">Article</h4>
            </div>
            <div>
                <a href="{{ route('articles.create',['event' => $event->id]) }}" class="btn btn-success">
                    Create new article
                </a>
            </div>
        </div>
        <div class="card mb-4" id="articles">
            <div class="card-body">
                <table id="article_datatable" data-url="{{ route('articles.datatable', $event->id) }}" class="table-hover table-bordered table-striped w-100"></table>
            </div>
        </div>
    </div>
</div>
