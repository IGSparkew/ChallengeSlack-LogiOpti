'use client';

export default function Login() {

    async function authSubmit(event) {
        event.preventDefault();
        const formData = new FormData(event.target)
        if (formData) {
            const email = formData.get("email");
            const password = formData.get("password");
            if (email && password) {
                const user = createUser(email, password);
                const res = await login(user);
                if (res != null && res.token != null) {
                    localStorage.setItem("token", res.token);
                    const role = getRole(res.token);
                    
                }
            }
        }
    }

    async function login(user) {  
        if (user != null && user.username != null && user.password != null) {
            const res = await fetch("http://localhost:8000/login", {
                    method: "POST",
                    cache: "no-cache",
                    headers: {
                        "Content-Type": "application/json",                        
                    },
                    body: JSON.stringify(user)
                });
            return  res.json();
        } 
    }

    async function getRole(token) {  
        if (token != null) {
            const bearerToken =  "Bearer " + token;
            const res = await fetch("http://localhost:8000/api/user/role", {
                    method: "GET",
                    cache: "no-cache",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": bearerToken                
                    },
                });
            return  res.json();
        } 
    }


    function createUser(email, password) {
        return {
            "username": email,
            "password": password
        }
    }

    return (
        <div className="min-h-screen bg-gray-100 flex flex-col justify-center sm:py-12">
            <div className="p-10 xs:p-0 mx-auto md:w-full md:max-w-md">
                <div className="flex flex-wrap justify-center">
                    <img
                        className="w-1/2 my-6"
                        src="/logo.png"
                        alt="logo logiOpti"
                    />
                </div>
                <div className="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
                    <form onSubmit={authSubmit} className="px-5 py-7">
                        <label className="font-semibold text-sm text-gray-600 pb-1 block">E-mail</label>
                        <input type="text" name="email" className="border rounded-lg text-black px-3 py-2 mt-1 mb-5 text-sm w-full" required />
                        <label className="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
                        <input type="password" name="password" className="border rounded-lg text-black  px-3 py-2 mt-1 mb-5 text-sm w-full" required />
                        <button type="submit" className="transition duration-200 bg-redFull hover:bg-white hover:text-redFull focus:shadow-sm focus:ring-4 focus:ring-white focus:ring-opacity-50 w-full text-white py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                            <span className="inline-block mr-2">Login</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" className="w-4 h-4 inline-block">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );

}