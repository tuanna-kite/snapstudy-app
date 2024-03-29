<div class="rounded-2xl p-20 bg-white flex items-center justify-center">
    <div class="flex flex-col items-center gap-6">
        <div class="rounded-full
        border border-dashed size-32
        bg-center bg-cover
        bg-no-repeat bg-clip-content p-2
        "
            style="background-image: url('{{ (!empty($user)) ? $user->getAvatar(150) : '' }}')">
            <input type="file" name="profile_image" id="profile_image" class="hidden @error('profile_image')  is-invalid @enderror" accept="images/*">
            <label for="file"
                class="w-full h-full rounded-full
                bg-black opacity-50
                 flex flex-col justify-center items-center
                gap-2
            ">
                <x-component.icon name="icon_camera" />
                <span class="text-white font-normal text-xs">
                    Update Photo
                </span>
            </label>
        </div>
        <p class="text-center font-normal text-xs text-text.light.secondary">
            Allowed *.jpeg, *.jpg, *.png, *.gif<br />
            Max size of 3.1 MB
        </p>
    </div>
    <div class="invalid-feedback">

    </div>
</div>
