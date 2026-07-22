@extends('layouts.admin')
@push('title', get_phrase('Gamification Badges'))
@push('meta')@endpush
@push('css')@endpush


@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Gamification Badges') }}</span>
                </h4>
            </div>
        </div>
    </div>

    <!-- Start Admin area -->
@php
$badgeTypes = [
    'course_count'        => 'Number Of Courses',
    'course_ratings'      => 'Number Of Course Ratings',
    'course_sale'         => 'Number Of Course Sales',
    'blog'                => 'Number Of Blogs',
    'course_completed'    => 'Number Of Course Completed',
    'course_certificates' => 'Number Of Course Certificate',
];
@endphp

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="ol-card p-4">
            <div class="ol-card-body">

                {{-- Tabs --}}
                <ul class="nav nav-tabs eNav-Tabs-custom eTab" role="tablist">
                    @foreach($badgeTypes as $key => $label)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#{{ $key }}"
                                    type="button"
                                    role="tab">
                                {{ get_phrase($label) }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content eNav-Tabs-content mt-3">

                    @foreach($badgeTypes as $key => $label)

                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                             id="{{ $key }}"
                             role="tabpanel">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="title fs-16px">
                                    {{ get_phrase($label) }}
                                </h4>

                                <a href="javascript:void(0)"
                                   class="btn ol-btn-outline-secondary d-flex align-items-center"
                                   onclick="ajaxModal('{{ route('modal', ['admin.gamification_badge.create']) }}?type={{ $key }}', 'Add Gamification Badge')">
                                    <span class="fi-rr-plus me-1"></span>
                                    {{ get_phrase('Add Badges') }}
                                </a>
                            </div>

                            {{-- Table --}}
                            <div class="table-responsive">
                                <table class="table eTable eTable-plain table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>{{ get_phrase('Image') }}</th>
                                            <th>{{ get_phrase('Title') }}</th>
                                            <th>{{ get_phrase('Condition') }}</th>
                                            <th>{{ get_phrase('Description') }}</th>
                                            <th>{{ get_phrase('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $filteredBadges = $badges->where('type', $key);
                                        @endphp

                                        @forelse($filteredBadges as $badge)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('uploads/badges/'.$badge->image) }}"
                                                         alt="{{ $badge->title }}"
                                                         width="50" height="50">
                                                </td>

                                                <td>{{ $badge->title }}</td>

                                                <td>
                                                    {{ $badge->condition_from }}
                                                    {{ get_phrase('to') }}
                                                    {{ $badge->condition_to }}
                                                </td>

                                                <td>{{ $badge->description }}</td>

                                                <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                                <a class="dropdown-item"  href="javascript:void(0);"
                                                                   onclick="ajaxModal('{{ route('modal', ['admin.gamification_badge.edit', 'id' => $badge->id]) }}', 'Edit Gamification Badge')">
                                                                    {{ get_phrase('Edit') }}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                   onclick="confirmModal('{{ route('admin.gamification.badge.delete', $badge->id) }}')">
                                                                    {{ get_phrase('Delete') }}
                                                                </a>
                                                            </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">
                                                    {{ get_phrase('No badges found') }}
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>
        </div>
    </div>
</div>
    <!-- End Admin area -->
@endsection
@push('js')@endpush
