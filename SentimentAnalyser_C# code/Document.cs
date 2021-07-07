using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace SentimentAnalysisAPI
{
    public class Document
    {
        [JsonProperty("id")]
        public string Id { get; set; }
        [JsonProperty("language")]
        public string Language { get; set; }
        [JsonProperty("text")]
        public string Text { get; set; }
    }
}
