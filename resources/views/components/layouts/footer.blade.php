<footer class="bg-primary.light">
    <div>
        {{--  --}}
        <div class='flex flex-col gap-12 pt-12 md:flex-row container mx-auto'>
            <div class="flex-1">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/logo/logo.png') }}" alt="Logo">
                </a>
                <ul class="mt-4 space-y-2">
                    <li class="text-sm font-semibold text-text.light.primary">
                        <a>
                            {{-- {{ trans('footer.The service provides detailed outlines for all student assignments') }} --}}
                            Dịch vụ cung cấp các outline chi tiết cho tất cả các bài tập của sinh viên
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a>
                            {{-- {{ trans('footer.Hong Linh Education Investment and Development Joint Stock Company') }} --}}
                            CÔNG TY CỔ PHẦN ĐẦU TƯ VÀ PHÁT TRIỂN GIÁO DỤC HỒNG LĨNH
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a>
                            {{-- {{ trans('footer.Address: No. 159 Thinh Quang Lane, Thinh Quang Street, Thinh Quang Ward, Dong Da District, Hanoi City, Vietnam.') }} --}}
                            Địa chỉ: Số 159 ngõ Thịnh Quang, Phố Thịnh Quang, Phường Thịnh Quang, Quận Đống Đa, Thành
                            phố Hà Nội,
                            Việt Nam.
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a>
                            Mã số thuế: 0110516044 do Sở kế hoạch và Đầu tư cấp ngày 20/10/2023
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a>
                            Email: honglinh.education@gmail.com
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a>
                            Số điện thoại: 0383664415
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a>
                            Người chịu trách nhiệm quản lý website: Vũ Quang Minh – Tổng giám đốc
                        </a>
                    </li>
                    {{-- <li class="text-sm text-text.light.secondary">
                        <a target="_blank" href="https://snapstudy.co/">
                            Web: https://snapstudy.co/
                        </a>
                    </li> --}}
                </ul>
            </div>
            <div class="flex flex-1">
                {{-- <div class="flex-1 pt-4">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7449.293207080257!2d105.8163281750308!3d21.006798580637057!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac83182c73b7%3A0xa9797bddf3554056!2zMTU5IE5nLiBUaOG7i25oIFF1YW5nLCBUaOG7i25oIFF1YW5nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpLCBWaWV0bmFt!5e0!3m2!1sen!2sus!4v1720205428510!5m2!1sen!2sus"
                        width="90%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <span class="text-base font-semibold text-text.light.primary uppercase">
                        {{ trans('footer.Support') }}
                        Hỗ trợ
                    </span>
                    <ul class="space-y-2 mt-3">
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Frequently asked questions') }}
                                Câu hỏi thường gặp
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Outline user manual') }}
                                Hướng dẫn sử dụng outline
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Payment Guide') }}
                                Hướng dẫn thanh toán
                            </a>
                        </li>
                    </ul>
                </div> --}}
                <div class="flex-1 pt-4">
                    <span class="text-base font-semibold text-text.light.primary uppercase">
                        Thông tin
                    </span>
                    <ul class="space-y-2 mt-3">
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="{{ route('information', ['slug' => 'guidelines']) }}">
                                Hướng dẫn mua khóa học ôn tập
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="{{ route('information', ['slug' => 'payment-policy']) }}">
                                Chính sách thanh toán
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="{{ route('information', ['slug' => 'privacy-policy']) }}">
                                Chính sách bảo mật thông tin khách hàng
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="{{ route('information', ['slug' => 'refund-policy']) }}">
                                Chính sách đổi trả và hoàn tiền
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="{{ route('information', ['slug' => 'complaint-process']) }}">
                                Quy trình tiếp nhận và xử lý khiếu nại
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class='flex flex-col pt-4 pb-8 gap-12 md:flex-row container mx-auto'>
            <div class="flex-1">
                {{--                <img src="{{ asset('img/image-footer.png') }}" /> --}}
            </div>
            <div class="flex flex-1 items-start">
                {{-- <div class="flex-1 space-y-2">
                    <p class="uppercase text-sm text-text.light.secondary">
                        {{ trans('footer.Payment support') }}
                    </p>
                    <ul class="flex gap-3">
                        <li>
                            <img src="{{ asset('img/logo/paypal.png') }}" alt=""
                                class="w-10 h-10 aspect-square rounded-md">
                        </li>
                        <li>
                            <img src="{{ asset('img/logo/visa-footer.png') }}" alt=""
                                class="w-10 h-10 aspect-square">
                        </li>
                        <li>
                            <img src="{{ asset('img/logo/mastercard.png') }}" alt=""
                                class="w-10 h-10 aspect-square">
                        </li>
                    </ul>
                </div> --}}
                <div class="flex-1 space-y-2">
                    <p class="uppercase text-sm text-text.light.secondary">
                        {{-- {{ trans('footer.connect with us') }} --}}
                        Kết nối với chúng tôi
                    </p>
                    <ul class="flex gap-3">
                        <li>
                            <a href="https://www.facebook.com/Snapszone" target="_blank">
                                <img src="{{ asset('img/logo/facebook-footer.png') }}" alt=""
                                    class="w-10 h-10 aspect-square">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </div>


    <div style="border-top:1px solid #637381">
        <div class="container mx-auto py-6">
            <div>
                <span class="text-sm font-medium text-text.light.secondary">
                    © 2024 Snaps. All rights reserved.
                </span>
            </div>
        </div>
    </div>
</footer>

@push('scripts_bottom')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbmMA0ywi7dvJCEzsWig3MrU-xkMbn7wI&callback=initMap" async
        defer></script>
    <script>
        function initMap() {
            var location = {
                lat: 21.0067986,
                lng: 105.8163282
            };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>
@endpush
