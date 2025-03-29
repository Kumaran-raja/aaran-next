<x-Ui::forms.m-panel :margin="'my-12'">
        <div class="flex-col gap-6  my-6">
            <div class="font-merri sm:w-full mx-auto text-xl py-4 border-b border-gray-300">Form</div>
            <div class="sm:w-6/12 w-full mx-auto border border-pink-500 p-5 rounded-md mt-6 shadow-md shadow-gray-500">
                <form action="" class="sm:w-3/6 w-full mx-auto grid text-center justify-items-center gap-6">
                    <x-Ui::input.floating :label="'Name'"/>
                    <x-Ui::input.floating :label="'Email'"/>
                    <x-Ui::input.floating :label="'Contact'"/>
                    <x-Ui::input.textarea label="comments" ></x-Ui::input.textarea>
                    <div class="inline-flex items-center">
                        <x-Ui::input.checkbox-new/>
                        <div>Terms and Services</div>
                    </div>
{{--                    <x-Ui::button.register/>--}}
                </form>
            </div>
        </div>
</x-Ui::forms.m-panel>
