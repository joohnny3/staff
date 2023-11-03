@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center flex-column">
        <div class="card card-primary mx-5 my-5">
            <div class="card-header">
                <h3 class="card-title">{{ $staff->name }}</h3>
                <div class="card-tools">
                    <!-- Collapse Button -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                {{ $staff->phone }}
            </div>
            <div class="card-footer">
                {{ $staff->address }}
            </div>
        </div>

        <div class="card mx-5 card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $staff->name }}的留言</h3>
                <div class="card-tools">
                    <!-- Maximize Button -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->

            @foreach ($staff->boards as $board)
                @if (!isset($board->board_id))
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5>
                                {{ $board->content }}
                            </h5>
                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample{{ $loop->iteration }}"
                                role="button" aria-expanded="false" aria-controls="collapseExample{{ $loop->iteration }}">
                                reply
                            </a>
                        </div>
                        @if (isset($board->reply_content))
                            <div>
                                <div class="text-warning">
                                    {{ $board->reply_content }}
                                </div>
                            </div>
                        @endif

                        <div>
                            <div class="collapse my-2" id="collapseExample{{ $loop->iteration }}">
                                <div class="card card-body">


                                    <form action="{{ route('board.store', ['staff' => $staff->id]) }}" method="post">
                                        @csrf

                                        <input type="hidden" name="board_id" value="{{ $board->id }}">

                                        <div class="input-group">
                                            <input type="text" name="content" placeholder="Type Message ..."
                                                class="form-control">
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="card-footer">
                <form action="{{ route('board.store', ['staff' => $staff->id]) }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="content" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
