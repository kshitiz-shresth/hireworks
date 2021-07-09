<div class="col-2">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">
                        <b>Edit Position</b>
                    </h3>
                    <div id="jobs-sidemenu">
                        <button class="buttons {{ request('page') == 1 ? 'active' : '' }}" >
                            <a href="/admin/jobs/show?id={{ request('id') }}&page=1">
                                <i class="fa fa-user fa-lg main-icon-1"></i>
                                <p class="main_text">Details</p> 
                            </a>
                        </button>
                        <button class="buttons {{ request('page') == 2 ? 'active' : '' }}"  disabled="">
                            <a href="/admin/jobs/show?id={{ request('id') }}&page=2"><i class="fa fa-cog fa-lg main-icon-1"></i>
                                <p class="main_text">Description</p> 
                            </a>
                        </button>
                        <button class="buttons {{ request('page') == 3 ? 'active' : '' }}" disabled="">
                            <a href="/admin/jobs/show?id={{ request('id') }}&page=3"><i class="fa fa-key fa-lg main-icon-1"></i>
                            <p class="main_text">Hiring Team</p></a>
                        </button>
                        <button class="buttons {{ request('page') == 4 ? 'active' : '' }}" disabled="">
                            <a href="/admin/jobs/show?id={{ request('id') }}&page=4"><i class="fa fa-book fa-lg main-icon-1"></i>
                            <p class="main_text">Assessment</p></a>
                        </button>
                        <button class="buttons {{ request('page') == 5 ? 'active' : '' }}" disabled="">
                            <a href="/admin/jobs/show?id={{ request('id') }}&page=5"><i class="fa fa-bullhorn fa-lg main-icon-1"></i>
                            <p class="main_text">Advertise</p></a>
                        </button>
                    </div>
                </div>
            </div>
        </div>