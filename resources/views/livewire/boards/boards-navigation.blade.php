<li class="nav-item">
    <!-- label-->
    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
        <div class="col-auto navbar-vertical-label">Tableros
        </div>
        <div class="col ps-0">
            <hr class="mb-0 navbar-vertical-divider" />
        </div>
    </div>
    <!-- parent pages--><a class="nav-link dropdown-indicator" href="#boards" role="button" data-bs-toggle="collapse"
        aria-expanded="false" aria-controls="user">
        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-th-large"></span></span><span
            class="nav-link-text ps-1">Tableros</span>
        </div>
    </a>
    <!-- child pages-->
    <ul class="nav collapse false" id="boards">
        @foreach ($boards as $board)
            <li class="nav-item"><a class="nav-link" href="{{ route('boards.index',$board) }}" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text ps-1 ">{{ ucfirst($board->name) }}
                    </span>
                    <span class="badge rounded-pill bg-warning mx-2">{{ explode(' ', $board->owner->name)[0] }}</span>
                    </div>
                </a>
                <!-- more inner pages-->
            </li>
        @endforeach
    </ul>
</li>
