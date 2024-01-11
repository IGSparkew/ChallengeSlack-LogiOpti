

export default function HeaderAuth () {
    return (
        <div class="min-w-screen min-h-screen bg-gray-100 flex items-center justify-center px-5 pt-5 pb-24">
        <div class="w-full max-w-md mx-auto">
            <div class="px-7 bg-white shadow-lg rounded-2xl mb-5">
                <div class="flex">
                    <div class="flex-1 group">
                        <a href="#" class="flex items-end justify-center text-center mx-auto px-4 pt-2 w-full text-gray-400 group-hover:text-indigo-500 border-b-2 border-transparent group-hover:border-indigo-500">
                            <span class="block px-1 pt-1 pb-2">
                                <i class="far fa-home text-2xl pt-1 mb-1 block"></i>
                                <span class="block text-xs pb-1">Login</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex-1 group">
                        <a href="#" class="flex items-end justify-center text-center mx-auto px-4 pt-2 w-full text-gray-400 group-hover:text-indigo-500 border-b-2 border-transparent group-hover:border-indigo-500">
                            <span class="block px-1 pt-1 pb-2">
                                <i class="far fa-compass text-2xl pt-1 mb-1 block"></i>
                                <span class="block text-xs pb-1">Register</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
      </div>
    );


}