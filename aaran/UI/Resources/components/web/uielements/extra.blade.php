<x-Ui::forms.m-panel>
    <div class="grid sm:grid-cols-2 sm:gap-6 grid-cols-1 ">
        <div>
            <div class="font-merri w-full mx-auto text-xl py-4 border-b border-gray-300">Accordion</div>
            <div class="py-6">
                <x-Ui::accordion.wrapper>
                    <x-Ui::accordion.header>
                        Color
                    </x-Ui::accordion.header>
                    <x-Ui::accordion.item>
                        Color or colour is the visual perception based on the electromagnetic spectrum.
                        Though color is not an inherent property of matter, color perception is related
                        to an object's light absorption, reflection, emission spectra, and interference.
                    </x-Ui::accordion.item>
                </x-Ui::accordion.wrapper>
                <x-Ui::accordion.wrapper>
                    <x-Ui::accordion.header>
                        Layout
                    </x-Ui::accordion.header>
                    <x-Ui::accordion.item>
                        Website layout is the arrangement, sequence, and placement of elements on a web page.
                        This determines the order of awareness that the users pay
                    </x-Ui::accordion.item>
                </x-Ui::accordion.wrapper>
                <x-Ui::accordion.wrapper>
                    <x-Ui::accordion.header>
                        Typography
                    </x-Ui::accordion.header>
                    <x-Ui::accordion.item>
                        Typography refers to the visual aspects of type, such as the choice of font and arrangement
                        of text. A crucial part of web design, typography
                    </x-Ui::accordion.item>
                </x-Ui::accordion.wrapper>
            </div>
        </div>
        <div>
            <div class="font-merri w-full mx-auto text-xl py-4 border-b border-gray-300">Tabs</div>
            <div class="py-6">
                <x-Ui::tabs.tabs-default/>
            </div>
        </div>

    </div>
</x-Ui::forms.m-panel>
