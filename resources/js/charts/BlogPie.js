// CommitChart.js
import { Doughnut } from 'vue-chartjs'

export default {
    extends: Doughnut,
    props: ['published', 'draft'],
    mounted () {
    	setTimeout(() => {
		    this.renderChart({
			    labels: ['Published', 'Draft'],
			    datasets: [
				    {
					    label: 'Blog Pie',
					    backgroundColor: ['#50e48b', '#dff1fd'],
					    data: [this.published, this.draft]
				    }
			    ]
		    })
    	}, 2000)
    }
}