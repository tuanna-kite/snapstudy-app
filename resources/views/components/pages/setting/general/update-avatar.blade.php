@php
    $user = auth()->user();
@endphp
<div class="rounded-2xl p-20 bg-white flex items-center justify-center">
    <div class="flex flex-col items-center gap-6">
        <div class="rounded-full
        border border-dashed size-32
        bg-center bg-cover
        bg-no-repeat bg-clip-content p-2"
            id="previewImage" style="background-image: url('{{ asset(!empty($user) ? $user->getAvatar(150) : '') }}')">
            <input type="file" name="file" id='file' class="hidden" accept="images/*">
            <input type="hidden" name="profile_image" id='base64file' class="hidden">
            <label for="file"
                class="w-full h-full rounded-full
                bg-black opacity-50
                 flex flex-col justify-center items-center
                gap-2
                cursor-pointer
            ">
                <x-component.icon name="icon_camera" />
                <span class="text-white font-normal text-xs">
                    {{ trans('dashboard.Update Photo') }}
                </span>
            </label>
        </div>
        <p class="text-center font-normal text-xs text-text.light.secondary">
            {!! trans('dashboard.Allowed') !!}
        </p>
    </div>
    <div class="invalid-feedback">

    </div>
</div>

@push('scripts_bottom')
    <script>
        document.getElementById('file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').style.backgroundImage = `url('${e.target.result}')`;
            }
            reader.readAsDataURL(file);
        });
    </script>
    <script>
        document.getElementById('file').addEventListener('change', function() {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function(event) {
                var imageData = event.target.result;
                document.getElementById('previewImage').src = imageData; // Hiển thị trước hình ảnh cho người dùng (tùy chọn)
                document.getElementById('base64file').value = imageData; // Đặt giá trị của trường ẩn thành dữ liệu base64
            };

            reader.readAsDataURL(file);
        });
    </script>

@endpush
