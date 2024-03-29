<div class="flex flex-wrap gap-4 bg-white p-6 rounded-2xl justify-between">
    <div class="w-[48%]">
        <p>Name</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="full_name"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->full_name : old('full_name') }}">
    </div>
    <div class="w-[48%]">
        <p>Email</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="email"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->email : old('email') }}">
    </div>
    <div class="w-[48%]">
        <p>Phone Number</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="mobile"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->mobile : old('mobile') }}">
    </div>
    <div class="w-[48%]">
        <p>Address</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="address"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->address : old('address') }}">
    </div>
    <div class="w-[48%]">
        <p>Country</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="country"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->country : old('country') }}">
    </div>
    <div class="w-[48%]">
        <p>State/Region</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="region"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->region : old('region') }}">
    </div>
    <div class="w-[48%]">
        <p>City</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="city"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->city : old('city') }}">
    </div>
    <div class="w-[48%]">
        <p>Zip/Code</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="code"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->code : old('code') }}">
    </div>
    <div class="w-full">
        <p>About</p>
        <textarea class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8"  name="about"
                  placeholder="">{!! (!empty($user) and empty($new_user)) ? $user->about : old('about')  !!}</textarea>
    </div>
    <div class="flex justify-end w-full">
        <x-button.button text="Save Changes" />
    </div>
</div>
