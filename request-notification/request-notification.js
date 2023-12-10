updateIndicators();

async function fetchNewRequestsStatus(category) {
    try {
        const response = await fetch('../request-notification/check-status-request.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ category: category }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        console.log(data);
        return data.result; 
    } catch (error) {
        console.error('Error fetching new requests status:', error);
        return 0; 
    }
}

async function updateIndicators() {
    try {
        const newComlabUsageRequests = await fetchNewRequestsStatus('comlab usage');
        const newEquipmentRequests = await fetchNewRequestsStatus('equipment');
        const newRepairRequests = await fetchNewRequestsStatus('repair');
        
        const anyNewRequests = newComlabUsageRequests > 0 || newEquipmentRequests > 0 || newRepairRequests > 0;
        if (anyNewRequests) {
            document.getElementById('requestIndication').style.display = 'inline';
        } else {
            document.getElementById('requestIndication').style.display = 'none';
        }
        
        document.getElementById('comlabUsageIndicator').style.display = newComlabUsageRequests > 0 ? 'inline' : 'none';
        document.getElementById('equipmentIndicator').style.display = newEquipmentRequests > 0 ? 'inline' : 'none';
        document.getElementById('repairIndicator').style.display = newRepairRequests > 0 ? 'inline' : 'none';
    }catch (error) {
        console.error('Error updating indicators: ', error);
    }
}

setInterval(updateIndicators, 500000);

//Function to update the notify status and indicator
async function updateNotifyStatusAndIndicator(category) {
    try {
        const response = await fetch('../request-notification/update-notify-status-indicator.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ category: category }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            console.log(`Notify status updated for ${category}`);

        } else {
            console.error('Failed to update notify status:', data.error);
        }
    } catch (error) {
        console.error('Error updating notify status:', error);
    }
}

document.getElementById('comlabUsageLink').addEventListener('click', function () {
    updateNotifyStatusAndIndicator('comlab usage');
});
document.getElementById('requestEquipmentLink').addEventListener('click', function () {
    updateNotifyStatusAndIndicator('equipment');
});
document.getElementById('terminalRepairLink').addEventListener('click', function () {
    updateNotifyStatusAndIndicator('repair');
});