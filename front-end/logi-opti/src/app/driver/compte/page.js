"use client"

import Titre from "../components/Titre";
import Header from "../components/Header";
import InfosCompte from "../components/InfosCompte";
import { useEffect } from "react";
import { useRouter } from "next/navigation";
import { isDriverUser } from "@/app/middleware/authMiddleware";

export default function Compte() {

    const router = useRouter();

    useEffect(() => {
        if (!isDriverUser()) {
            router.push('/', "push");
        }
    }, []);

    return(
        <main>
            <Header/>
            <div className="flex flex-col gap-8 text-black px-10 mt-12  w-full">
                <Titre page="Mon Compte"/>
                <InfosCompte/>
            </div>
        </main>
    );
}