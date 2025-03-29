<div>
    <div class="relative ">
        @if (session('success'))
            <div id="flash-message" class="fixed top-[20px] right-0 transform -translate-x-1/2 bg-green-500 text-white p-3 rounded-md shadow-lg z-[9999] w-auto">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('flash-message').style.display = 'none';
                }, 5000); // Hide after 5 seconds
            </script>
        @endif
        <img src="{{ asset('images/contact/contact header.jpg') }}" class="w-full" alt="">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white bg-black/50">
            <h1 class="text-3xl sm:text-6xl font-bold">Contact us</h1>
            <p class="text-lg">Get In Touch</p>
        </div>
    </div>
    <div class="block sm:flex justify-around -mt-8 z-0 relative">
        <div class="flex flex-col gap-y-2 mx-auto text-center w-2/3 sm:w-2/5 l bg-gray-700 p-4 rounded-lg text-white">
            <img src="{{asset('images/contact/call.png')}}" class="mx-auto" width="50px" height="50px" alt="">
            <p class="text-3xl bold">Contact </p>
            <p class="text-xl">Reach out to us anytime – we're here to help!</p>
            <p>+91 9655227738</p>
            <a class="mb-2" href="mailto:info@aarnerp.com">info@aarnerp.com</a>
            <a href="tel:9655227738" class="mt-auto bg-orange-500 text-white p-2 rounded-md">Call Now</a>
        </div>
        <div class="mt-0 sm:mt-5 flex flex-col gap-y-2 mx-auto text-center w-2/3 sm:w-2/5 l bg-gray-700 p-4 rounded-lg text-white">
            <img src="{{asset('images/contact/office-address.png')}}" class="mx-auto" width="50px" height="50px" alt="">
            <h1 class="text-3xl bold">Address </h1>
            <p class="text-xl">Visit us at our office – let's connect in person!</p>
            <p>AARAN INFO TECH</p>
            <p class="mb-2">10-A Venkatappa Gounder Street,
                Postal Colony, P.N.road,
                Tiruppur - 641602
                Tamilnadu, INDIA.</p>
            <a href="https://maps.app.goo.gl/jaspveZYtdDkAmG48" target="_blank" class="mt-auto bg-orange-500 text-white p-2 rounded-md">Location</a>
        </div>
    </div>
    <h1 class="text-center text-5xl bold my-7">Quick Contact</h1>
    <div class="my-5">
        <form action="/contact" method="post" class="flex flex-col items-center gap-y-3">
            @csrf
            <input type="text" name="name" placeholder="Enter Your Name" class="w-2/3 p-2 lg:w-1/4 rounded-md"/><br/>
            <input type="text" name="email" placeholder="Enter Email Address" class="w-2/3 p-2  lg:w-1/4 rounded-md"/><br/>
            <input type="text" name="phone" placeholder="Enter Your Phone" class="w-2/3 p-2 lg:w-1/4 rounded-md"/><br/>
            <textarea type="text" name="message" placeholder="Message" class="w-2/3 p-2 lg:w-1/4 rounded-md"></textarea><br/>
            <button type="submit" class="mt-auto bg-orange-500 text-white p-2 rounded-md w-2/3 lg:w-1/4">Submit</button>
        </form>
    </div>

</div>
