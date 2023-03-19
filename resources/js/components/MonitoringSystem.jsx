import React, {useEffect, useState} from 'react';
import ReactDOM from "react-dom/client";
function MonitoringSystem() {
   const [notifications,setNotifications] = useState([]);

    useEffect(()=>{
        Echo.channel('bankSystem')
            .listen('MonitorBankSystem', (data) => {
                setNotifications(prevNotifications=>[...prevNotifications,data]);
            });
    },[])

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">The Monitoring System!</div>

                        <div>
                        {notifications.map((item,key)=>{
                           return <p key={key}>{item.message}</p>
                        })}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default MonitoringSystem;
//
// if (document.getElementById('monitoring-system')) {
//     const Index = ReactDOM.createRoot(document.getElementById("monitoring-system"));
//
//     Index.render(
//         <React.StrictMode>
//             <MonitoringSystem/>
//         </React.StrictMode>
//     )
// }
