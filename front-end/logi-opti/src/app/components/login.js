'use client';

import { redirect } from "next/dist/server/api-utils";
import { ApiService } from "../services/apiService";
import { useRouter } from "next/navigation";

export default function Login() {

    const api = new ApiService();
    const router = useRouter();

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
                    const role = await getRole(res.token);
                    localStorage.setItem("token", res.token);
                    localStorage.setItem("role", role.role[0]);
                    redirectUserTo();
                }
            }
        }
    }

    function redirectUserTo() {
        let role = localStorage.getItem("role");
        if (role != null) {
            switch (role) {
                case "ROLE_DRIVER":
                    router.push('/driver', "push");
                    break;
                case "ROLE_OFFICE":
                    router.push('/client',"push")
                    break;
                case "ROLE_ADMIN":
                    router.push('/client',"push")
                    break;
                default:
                    break;
            }
            
        }
    }

    async function login(user) {  
        if (user != null && user.username != null && user.password != null) {
            return await api.post('/login', user);
        } 
    }

    async function getRole(token) {  
        if (token != null) {
          return await api.get('/api/user/role', token);
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