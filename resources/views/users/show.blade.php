@extends('layouts.app')

@section('content')
        <div class="row">
            <aside class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $user->name }}</h3>
                    </div>
                </div>
            </aside>
            <div class="col-sm-8">
              <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item">
                    <a href="{{ route('users.show', ['user' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
                        TimeLine
                        <span class="badge badge-secondary">{{ $user-> tasks_count }}</span>
                    </a>
                </li>
              </ul>
              @if
                {{-- 投稿フォーム --}}
                 @include('tasks.form')
              @endif
                {{-- 投稿一覧 --}}
                @include('tasks.tasks')
            </div>
        </div>
@endsection