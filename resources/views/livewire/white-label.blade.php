<div>
    <div class="card mb-5 mb-xl-10">
        <!--begin::Body-->
        <div class="card-body py-10">
            <h2 class="mb-9">White Label Program</h2>
            <!--begin::Overview-->
            <div class="row mb-10">
                <!--begin::Col-->
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-12">
                    <h4 class="text-gray-800 mb-0">Domain</h4>
                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">Plan your blog post by choosing a topic, creating an outline conduct
                    <br>research, and checking facts</p>
                    <div class="d-flex">
                        <input  wire:model='domain' type="text" class="form-control form-control-solid me-3 flex-grow-1" >
                        <button  class="btn btn-primary btn-active-light-primary fw-bold flex-shrink-0" wire:click='saveDomain'>Save</button>
                    </div>
                </div>
                <div class="col-xl-12 mt-10">
                    <h4 class="text-gray-800 mb-0">Webhook</h4>
                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">Plan your blog post by choosing a topic, creating an outline conduct
                    <br>research, and checking facts</p>
                    <div class="d-flex">
                        <input wire:model='webhook'  type="text" class="form-control form-control-solid me-3 flex-grow-1">
                        <button  class="btn btn-primary btn-active-light-primary fw-bold flex-shrink-0" wire:click='saveWebhook'>Save</button>
                    </div>
                </div>
                <!--end::Col-->
            </div>

        </div>
    </div>

    <div class="card">
        <!--begin::Header-->
        <div class="card-header card-header-stretch">
            <!--begin::Title-->
            <div class="card-title">
                <h3>User Report</h3>
            </div>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar">
                <!--begin::Tab nav-->
                <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs border-transparent" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_tab_1" class="nav-link text-active-gray-800 me-4 active" data-bs-toggle="tab" role="tab" href="#kt_referrals_1" aria-selected="true">1st level</a>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <a id="kt_referrals_tab_2" class="nav-link text-active-gray-800 me-4" data-bs-toggle="tab" role="tab" href="#kt_referrals_2" aria-selected="false" tabindex="-1">2nd level</a>
                    </li> --}}
                    {{-- <li class="nav-item" role="presentation">
                        <a id="kt_referrals_tab_3" class="nav-link text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_referrals_3" aria-selected="false" tabindex="-1">2021</a>
                    </li> --}}
                </ul>
                <!--end::Tab nav-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header-->
        <!--begin::Tab content-->
        <div id="kt_referred_users_tab_content" class="tab-content">
            <!--begin::Tab panel-->
            <div id="kt_referrals_1" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_referrals_tab_1">
                <div class="table-responsive">

                    {{-- <table class="table table-row-bordered align-middle gy-6">
                        <thead class="border-bottom border-gray-200 fs-6 fw-bold bg-lighten">
                            <tr>
                                <th>Date</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Total Minutes Worked</th>
                            </tr>
                        </thead>
                        <tbody class="fs-6 fw-semibold text-gray-600">
                            @foreach ($report as $date => $users)
                                <tr class="" style="text-align: center">
                                    <td colspan="4">{{ $date }}</td>
                                </tr>
                                @foreach ($users as $user)
                                    <tr>
                                        <td></td>
                                        <td>{{ $user['employee_id'] }}</td>
                                        <td>{{ $user['employee_name'] }}</td>
                                        <td>{{ $user['total_minutes'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table> --}}
                    <table class="table table-row-bordered align-middle gy-6">
                        <thead>
                            <tr>
                                <th class="min-w-125px  ps-9">Date</th>
                                @foreach ($userColumns as $user)
                                    <th class="min-w-125px  ps-9">{{ $user['name'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="fs-6 fw-semibold ">
                            @foreach ($report as $dailyData)
                                <tr @if ($dailyData['day'] == 'Sunday')
                                    style="background:rgb(227, 188, 188)"
                                @endif >
                                    <td class="min-w-125px  ps-9">{{ $dailyData['date'] }}</td>
                                    @foreach ($userColumns as $user)
                                        <td class="min-w-125px  ps-9">{{ $dailyData[$user['id']] ?? 0 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
            </div>

        </div>
        <!--end::Tab content-->
    </div>
</div>
