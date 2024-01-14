"use client"

import Titre from "../components/Titre";
import Header from "../components/Header";
import InfosCompte from "../components/InfosCompte";
import { useEffect, useState } from "react";
//import { useUser } from "@/app/context/userContext";
import { useRouter } from "next/navigation";
import { isDriverUser } from "@/app/middleware/authMiddleware";
import { ApiService } from "@/app/services/apiService";

export default function Compte() {
    const router = useRouter();
    const [user, setUser] = useState(null);
    const [trucks, setTrucks] = useState([]) 
    const api = new ApiService();

    useEffect(() => {
        if (!isDriverUser()) {
            router.push('/', "push");
        }
        const token = localStorage.getItem("token");
        api.get('/api/vehicle/get',token)
        .then((data) => {
            console.log(data);
            setTrucks(data);
        });
        api.get('/api/user/get', token)
        .then((data) => {
            setUser(getUser(data[0]));
        });
    }, []);

    function getUser(data) {
        const user = {
            lastName: data.lastname,
            firstName: data.firstname,
            email: data.email,
            salary: data.salary
        };
        if (data.vehicle_id) {
            user.vehicle = data.vehicle_id
        }

        return user;
    }

    return(
        <main>
            <Header/>
            <div className="flex flex-col gap-8 text-black px-10 mt-12  w-full">
                <Titre page="Mon Compte"/>
                <InfosCompte user={user} trucks={trucks}/>
            </div>
        </main>
    );
}