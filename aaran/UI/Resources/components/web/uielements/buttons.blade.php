<x-Ui::forms.m-panel :margin="'my-12'">
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-6">
        <div>
            <div class="font-merri w-full mx-auto text-xl py-4 border-b border-gray-300">Alerts</div>
            <div class="grid grid-rows-4 gap-y-6 py-6">
                <x-Ui::alerts.info/>
                <x-Ui::alerts.success/>
                <x-Ui::alerts.warning/>
                <x-Ui::alerts.danger/>
            </div>
        </div>
        <div>
            <div>
                <div class="font-merri w-full mx-auto text-xl py-4 border-b border-gray-300">Buttons</div>
                <div class="grid sm:grid-cols-4 sm:gap-6 grid-cols-3 gap-4 py-6">
                    <x-Ui::button.new-x/>
                    <x-Ui::button.delete/>
                    <x-Ui::button.print-x/>
                    <x-Ui::button.back-x/>
                    <x-Ui::button.cancel-x/>
                    <x-Ui::button.save-x/>
{{--                    <x-Ui::button.register>Register</x-Ui::button.register>--}}
                    <x-Ui::button.primary>Primary</x-Ui::button.primary>
                    <x-Ui::button.secondary>Secondary</x-Ui::button.secondary>
{{--                    <x-Ui::button.loading/>--}}
                </div>
            </div>
            <div>
                <div class="font-merri w-full mx-auto text-xl py-4 border-b border-gray-300">Models</div>
                <div class="grid sm:grid-cols-4 sm:gap-6 grid-cols-2 gap-4 py-6">
                    <x-Ui::modal.default/>
                    <x-Ui::modal.success/>
                    <x-Ui::modal.info/>
                    <x-Ui::modal.warning/>
                    <x-Ui::modal.danger/>
                </div>
            </div>
        </div>
    </div>
    <div class=" flex-wrap flex items-center gap-5">
        <x-Ui::button.new-x/>
        <x-Ui::button.danger-x/>
        <x-Ui::button.save-x/>
        <x-Ui::button.back-x/>
        <x-Ui::button.cancel-x/>
        <x-Ui::button.print-x/>
        <x-Ui::button.e-invoice-x/>
        <x-Ui::button.e-way-x/>
        <x-Ui::button.e-cancel-x/>
    </div>

</x-Ui::forms.m-panel>
