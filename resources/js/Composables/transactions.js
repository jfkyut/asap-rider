export const useTransactions = () => {
    const statusSeverity = {
        pending: 'warning',
        accepted: 'info',
        in_progress: 'secondary',
        completed: 'success'
    };

    const getStatusSeverity = (status) => statusSeverity[status] || 'secondary';

    const formatDate = (date) => {
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    };

    const formatTime = (date) => {
        return new Date(date).toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    return {
        getStatusSeverity,
        formatDate,
        formatTime
    }
}