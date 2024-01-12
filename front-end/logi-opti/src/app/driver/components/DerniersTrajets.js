import Trajet from "./Trajet";
import {useRouter} from "next/navigation";
import {ApiService} from "@/app/services/apiService";
import {isDriverUser} from "@/app/middleware/authMiddleware";
import {useEffect, useState} from "react";


export default function DerniersTrajets({setOpen}) {
    const router = useRouter();
    const [trajet, setTrajet] = useState([]);
    const api = new ApiService();

    useEffect(() => {
        if (!isDriverUser()) {
            router.push('/', "push");
        }
        const token = localStorage.getItem("token");
        api.get('/api/delivery/get', token)
            .then((data) => {
                const trajetData = getTrajet(data);
                setTrajet(trajetData);
            })
    }, []);

    function getTrajet(data) {
        const trajet = [];

        data.forEach((element) => {
            var startDate = element.start_date.date.split('-')
            const month = startDate[1]
            startDate = startDate[2].split(' ')
            const day = startDate[0]
            trajet.push({
                startCity: element.startAddress.city,
                endCity: element.endAddress.city,
                startDate: `${month}/${day}`,
            });
        });

        return trajet;
    }

    return (
        <div className="flex flex-col gap-5 items-center justify-center bg-white px-5 shadow-box py-5">
            <h2 className="u-semi text-xl underline">Vos derniers trajets</h2>
            {trajet.map(function(item, index) {
                return (
                    <Trajet key={index} setOpen={setOpen} infosTrajet={`Trajet du ${item.startDate} :  ${item.startCity} -  ${item.endCity}`} />
                );
            })}
        </div>
    );

}