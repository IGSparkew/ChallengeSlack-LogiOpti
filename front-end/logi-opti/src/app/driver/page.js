
'use client'
import DerniersTrajets from "./components/DerniersTrajets";
import TrajetsAVenir from "./components/TrajetsAVenir";
import Header from "./components/Header";
import ModalArrivee from "./components/ModalArrivee";
import ModalDetails from "./components/ModalDetails";
import ModalAjoutUpdate from "./components/ModalAjoutUpdate";
import Titre from "./components/Titre";
import { useState, useEffect } from "react";
import { isDriverUser } from "../middleware/authMiddleware";
import { useRouter } from "next/navigation";
import {ApiService} from "@/app/services/apiService";

export default function Driver() {

    const [openDetails,setOpenDetails] = useState(false);
    const [details,setDetails] = useState([]);
    const [openArrivee,setOpenArrivee] = useState(false);
    const [openAjout,setOpenAjout] = useState(false);
    const [openUpdate,setOpenUpdate] = useState(false);
    const router = useRouter();
    const api = new ApiService();

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

    useEffect(() => {
        if (!isDriverUser()) {
            router.push('/', "push");
        }
        const token = localStorage.getItem("token");
        api.get('/api/delivery/get', token)
            .then((data) => {
                const trajetData = getTrajet(data);
                setDetails(trajetData);
            })
    }, []);

    function getTrajet(data) {
        const trajet = [];

        data.forEach((element) => {
            var startDate = element.start_date.date.split('-')
            const startYear = startDate[0]
            const startMonth = startDate[1]
            startDate = startDate[2].split(' ')
            const startDay = startDate[0]
            startDate = startDate[1].split(":")
            const startHour = startDate[0]
            const startMin = startDate[1]
            var endDate = element.end_date.date.split('-')
            const endYear = endDate[0]
            const endMonth = endDate[1]
            endDate = endDate[2].split(' ')
            const endDay = endDate[0]
            endDate = endDate[1].split(":")
            const endHour = endDate[0]
            const endMin = endDate[1]
            trajet.push({
                lastname: element.user.lastname,
                firstname: element.user.firstname,
                startStreet: element.startAddress.street,
                startPostalCode: element.startAddress.postalCode,
                endStreet: element.startAddress.street,
                endPostalCode: element.startAddress.postalCode,
                startDate: `${startYear}/${startMonth}/${startDay} ${startHour}H${startMin}`,
                endDate: `${endYear}/${endMonth}/${endDay} ${endHour}H${endMin}`,
                vehicleType: element.vehicle.vehicleType.type,
                tollCost : element.toll_cost,
                usingCost : element.using_cost,
                distance : element.distance,
                time : element.Time,
            });
        });
        return trajet;
    }

    return(
        <main>
            <Header/>
            <div className="flex flex-col gap-8 text-black px-10 mt-12  w-full">
                <Titre page="Trajets"/>
                <TrajetsAVenir setOpenArrivee={handleSetOpenArrivee} setOpenAjout={handleSetOpenAjout} setOpenUpdate={handleSetOpenUpdate} setOpenDetails={handleSetOpenDetails}/>
                <DerniersTrajets setOpen= {handleSetOpenDetails}/>
            </div>

            <ModalArrivee openArrivee={openArrivee} setOpenArrivee={setOpenArrivee}/>
            {details.map((item, index) => (
                <ModalDetails key={index} openDetails={openDetails} setOpenDetails={setOpenDetails} details={item} setDetails={setDetails}/>
            ))}
            <ModalAjoutUpdate openAjout={openAjout} openUpdate={openUpdate} setOpenAjout={setOpenAjout} setOpenUpdate={setOpenUpdate}/>
        </main>
    );
}