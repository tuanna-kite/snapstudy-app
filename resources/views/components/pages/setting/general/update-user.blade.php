<div class="flex flex-wrap gap-4 bg-white p-6 rounded-2xl justify-between">
    <div class="w-[48%]">
        <p>{{ trans('dashboard.Name') }}</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="full_name"
            placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->full_name : old('full_name') }}"
            @error('full_name') is-invalid @enderror">
        @error('full_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="w-[48%]">
        <p>{{ trans('dashboard.Email') }}</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="email"
            placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->email : old('email') }}">
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="w-[48%]">
        <p>{{ trans('dashboard.Phone Number') }}</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="mobile"
            placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->mobile : old('mobile') }}">
        @error('mobile')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="w-[48%]">
        <p>{{ trans('dashboard.Address') }}</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="address"
            placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->address : old('address') }}">

    </div>
    @error('address')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
    <div class="w-[48%]">
        <p>{{ trans('dashboard.Country') }}</p>
        <select id='country_id' name='country_id' class='w-full border border-grey-300 rounded-xl p-[18px]'>
            @foreach ($countries as $item)
                <option value={{ $item->id }}
                    {{ (!empty($user) and $user->country_id == $item->id) ? 'selected' : '' }}>{{ $item->value }}
                </option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{ $message }}
        </div>

    </div>
    <div class="w-[48%]">
        <p>{{ trans('dashboard.State/Region') }} </p>
        <select id='province_id' name='province_id' class='w-full border border-grey-300 rounded-xl p-[18px]'>
            @foreach ($listProvinces as $item)
                <option value={{ $item->id }}
                    {{ (!empty($user) and $user->province_id == $item->id) ? 'selected' : '' }}>{{ $item->value }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="w-[48%]">
        <p>{{ trans('dashboard.City') }}</p>
        <select id='city_id' name='city_id' class='w-full border border-grey-300 rounded-xl p-[18px]'>
            @foreach ($listCity as $item)
                <option value={{ $item->id }}
                    {{ (!empty($user) and $user->city_id == $item->id) ? 'selected' : '' }}>{{ $item->value }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="w-[48%]">
        <p>{{ trans('dashboard.Zip/Code') }}</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="code"
            placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->code : old('code') }}">
        @error('code')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="w-full">
        <p>{{ trans('dashboard.About') }}</p>
        <textarea class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" name="about" placeholder="">{!! (!empty($user) and empty($new_user)) ? $user->about : old('about') !!}</textarea>
        @error('about')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="flex justify-end w-full">
        <button type="submit" class="rounded-xl px-5 py-1.5 bg-primary.main text-white">
            <span class="font-medium text-sm">
                {{ trans('dashboard.Save Changes') }}
            </span>
        </button>
    </div>
</div>
