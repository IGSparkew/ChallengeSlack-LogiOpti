'use client'
import DerniersTrajets from "../components/DerniersTrajets";
import TrajetsAVenir from "../components/TrajetsAVenir";
import Header from "../components/Header";
import ModalArrivee from "../components/ModalArrivee";
import ModalDetails from "../components/ModalDetails";
import ModalAjoutUpdate from "../components/ModalAjoutUpdate";
import Maps from "../components/Maps";
import { useState } from "react";
import Titre from "../components/Titre";

import { useEffect } from "react";
import { useRouter } from "next/navigation";
import { isDriverUser } from "@/app/middleware/authMiddleware";

export default function Driver() {

    const [openDetails,setOpenDetails] = useState(false);
    const [openArrivee,setOpenArrivee] = useState(false);
    const [openAjout,setOpenAjout] = useState(false);
    const [openUpdate,setOpenUpdate] = useState(false);


    const router = useRouter();

    useEffect(() => {
        if (!isDriverUser()) {
            router.push('/', "push");
        }
    }, []);
  
    const handleSetOpenDetails = (data) => {
        setOpenDetails(data);
    }
    const handleSetOpenArrivee = (data) => {
        setOpenArrivee(data);
    }
    const handleSetOpenAjout = (data) => {
        setOpenAjout(data);
    }
    const handleSetOpenUpdate = (data) => {
        setOpenUpdate(data);
    }

    return(
        <main>
            <Header/>
            <div className="flex flex-col gap-8 text-black px-10 mt-12  w-full">
                <Titre page="Itinéraires"/>
                <TrajetsAVenir setOpenArrivee={handleSetOpenArrivee} setOpenAjout={handleSetOpenAjout} setOpenUpdate={handleSetOpenUpdate} setOpenDetails={handleSetOpenDetails}/>
                <Maps/>

            </div>

            <ModalArrivee/>
        </main>
    );
}